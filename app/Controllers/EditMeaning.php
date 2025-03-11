<?php

namespace App\Controllers;

use App\Libraries\Functions;
use App\Models\MeaningsModel;
use App\Models\TagsModel;
use App\Models\WordsModel;
use App\Models\WordMeaningModel;
use App\Models\WordMeaningTagsModel;

class EditMeaning extends BaseController
{
    protected $session;
    function __construct()
    {
        $this->session = session();
        helper(['form']);
    }

    public function edit($w_id = false, $wm_id = false)
    {
        if (!$this->session->has('mezegebe_kalat_user_email')) {
            return redirect()->route('login');
        }
        $request = service('request');
        $wordModel = new WordsModel();
        $obj_function = new Functions();

        $data = $obj_function->pageload(['flag <= ' => session()->get('dictionary_flag')]);
        $data = array_merge($data, $this->edit_page($w_id, $wm_id));

        if (is_numeric($wm_id) && $wm_id > 0) {
            $for_edit = $wordModel->getword(['words.word_id' => $w_id, 'wm.word_meaning_id' => $wm_id])[0];
            if (strtolower($request->getMethod()) === 'get' && count($for_edit) > 0) {

                $word_update = ['w_id' => $for_edit['word_id'], 'wm_id' => $for_edit['word_meaning_id'], 'm_id' => $for_edit['meaning_id']];
                $this->session->set($word_update);

                $data['word'] = $for_edit['word'];
                $data['pronunciation'] = $for_edit['pronunciation'];
                $data['meaning'] = $for_edit['meaning'];
                $data['example'] = $for_edit['example'];
                $data['short_note'] = $for_edit['short_note'];
                $data['dictionary_id'] = $for_edit['dictionary_id'];
                $data['page_no'] = $for_edit['page_no'];
                $data['alphabet_order'] = $for_edit['alphabet_order'];
                $data['comment'] = $for_edit['comment'];
                $data['num_like'] = $for_edit['num_like'];
                $data['num_dislike'] = $for_edit['num_dislike'];
                $data['user_report'] = $for_edit['user_report'];
                $data['accessibility2'] = $for_edit['accessibility'];
                $data['languagefrom_id'] = $for_edit['languagefrom_id'];
                $data['languageto_id'] = $for_edit['languageto_id'];
                $data['homonyms2'] = $for_edit['homonyms'];
                $data['part_of_speech2'] = $for_edit['part_of_speech_id'];
                $data['mflag'] = $for_edit['mflag'];
                $data['meaning_image'] = $for_edit['meaning_image'];
            }
        }
        $data['Breadcrumbs'] = 'Word Meaning List';
        return view('dictionary/edit',  $data);
    }

    public function update()
    {

        if (!$this->session->has('mezegebe_kalat_user_email')) {
            return redirect()->route('login');
        }
        $request = service('request');
        $wordModel = new WordsModel();
        $meaningModel = new MeaningsModel();
        $wordmeaningModel = new WordMeaningModel();
        $obj_function = new Functions();

        $data = $obj_function->pageload(['flag <= ' => session()->get('dictionary_flag')]);

        $rules = array_intersect_key($obj_function->getrules($data['is_list']), ['word' => '', 'languagefrom' => '', 'languageto' => '']);
        $rules = array_merge(
            $rules,
            $meaningModel->getValidationRules(['only' => ['meaning']]),
            $wordModel->getValidationRules(['only' => ['accessibility']]),
            // $tagModel->getValidationRules(['only' => ['tag']]),
        );

        if (strtolower($request->getMethod()) === 'post' && $this->validate($rules) && session()->get('w_id') > 0) {
            $word = $this->request->getPost('word');
            $pronunciation = $this->request->getPost('pronunciation');
            $accessibility = $this->request->getPost('accessibility');
            $languagefrom = $this->request->getPost('languagefrom');
            $short_note = $this->request->getPost('short_note');

            $meaning = $this->request->getPost('meaning');
            $example = $this->request->getPost('example');
            $homonym =  $this->request->getPost('homonyms') ? 'ጠብቆና ላልቶ የሚነበብ' : null; //array(1) { [0]=> string(3) "Yes"} 'Yes' : 'No'
            $part_of_speech = $this->request->getPost('part_of_speech');
            $languageto = $this->request->getPost('languageto');
            $meaning_image = $this->request->getFile('meaning_image');
            $mflag = $this->request->getPost('mflag');
            $alphabet_order = $this->request->getPost('alphabet_order');

            $dictionary = $this->request->getPost('dictionary');
            $page_no = $this->request->getPost('page_no');
            $comment = $this->request->getPost('comment');
            $user_report =  $this->request->getPost('user_report');

            $tags = $this->request->getPost('tag');

            $worddata = [
                'word' => $word, 'pronunciation' => $pronunciation, 'accessibility' => $accessibility > 0 ? $accessibility : null,
                'Language_id' => intVal($languagefrom), 'short_note' => $short_note
            ];

            $selectmeaning = $meaningModel->select('*')->where('meaning_id', session()->get('m_id'))->first();
            $meaningdata = [
                'meaning' => $meaning, 'example' => $example, 'homonyms' => $homonym, 'part_of_speech_id' => $part_of_speech > 0 ? $part_of_speech : null,
                'language_id' => intVal($languageto), 'meaning_image' => $selectmeaning['meaning_image'], 'alphabet_order' => $alphabet_order, 'flag' => intVal($mflag)
            ];

            $word_meaning_data = [
                'dictionary_id' => $dictionary, 'page_no' => $page_no, 'comment' => $comment, 'user_report' => $user_report > 0 ? $user_report : null
            ];
            $tag_data = ['tags' => $tags, 'word_meaning_id' => session()->get('wm_id'), 'user_id' => intVal($data['user_id'])];

            $imagename = $meaning_image->getRandomName();
            if ($meaning_image->isValid() && $meaning_image->move('public/asset/img/dictionary/', $imagename)) {
                $meaningdata['meaning_image'] = $imagename;
            }

            $wordfields = array_intersect_key($worddata, array_flip($wordModel->allowedFields));
            $selectword = $wordModel->select('*')->where('word_id', session()->get('w_id'))->first();
            $updateword = array_diff_assoc($wordfields, $selectword);
            empty($updateword) ? '' : $wordModel->word_update(session()->get('w_id'), $updateword);

            $meaningfields = array_intersect_key($meaningdata, array_flip($meaningModel->allowedFields));
            $updatemeaning = array_diff_assoc($meaningfields, $selectmeaning);
            empty($updatemeaning) ? '' : $meaningModel->meaning_update(session()->get('m_id'), $updatemeaning);

            $word_meaning_fields = array_intersect_key($word_meaning_data, array_flip($wordmeaningModel->allowedFields));
            $select_word_meaning = $wordmeaningModel->select('*')->where('word_meaning_id', session()->get('wm_id'))->first();
            $word_meaning['dictionary_id'] = $select_word_meaning->dictionary_id;
            $word_meaning['page_no'] = $select_word_meaning->page_no;
            $word_meaning['comment'] = $select_word_meaning->comment;
            $word_meaning['user_report'] = $select_word_meaning->user_report;
            $update_word_meaning = array_diff_assoc($word_meaning_fields, $word_meaning);
            empty($update_word_meaning) ? '' : $wordmeaningModel->word_Meaning_update(session()->get('wm_id'), $update_word_meaning);

            if (!is_null($tag_data['tags'])) {
                $tagModel = new TagsModel();
                $wordmeaningTagModel = new WordMeaningTagsModel();

                $tag_data['tag_id'] = $tagModel->insert_tag($tag_data);
                $wordmeaningTagModel->insert_word_meaning_tags($tag_data);
            }

        } else {
            return redirect()->route('wordmeaninglist');
        }
        $data['Breadcrumbs'] = 'Word Meaning List';
        $data = array_merge($data, $this->edit_page(session()->get('w_id'), session()->get('wm_id')));
        return view('dictionary/edit',  $data);
    }

    function edit_page($w_id = false, $wm_id = false)
    {
        $request = service('request');
        $wordModel = new WordsModel();
        $tagModel = new TagsModel();
        $wordtagModel = new WordMeaningTagsModel();
        $meaningModel = new MeaningsModel();
        $obj_function = new Functions();

        if (strtolower($request->getMethod()) === 'post' && isset($_POST['del'])) {
            $id_ = explode(',', $_POST['del']);
            $meaningModel->deleteMeaning(['m_id' => $id_[0], 'wm_id' => $id_[1]]);
        }
        $word_list = $wordModel->getword(['words.word_id' => $w_id]);
        $data = [
            'word' => '', 'pronunciation' => '', 'meaning' => '', 'example' => '', 'short_note' => '', 'accessibility2' => '', 'languagefrom_id' => '',
            'languageto_id' => '', 'part_of_speech2' => '', 'dictionary_id' => '', 'page_no' => '', 'comment' => '', 'num_like' => '', 'num_dislike' => '',
            'user_report' => '', 'mflag' => '', 'meaning_image' => '', 'alphabet_order' => '', 'homonyms2' => ''
        ]; //fileds
        $col = ['#', 'ቃል', 'ሰዋሰው', 'ጠብቆ', 'ትርጉም', 'ምሳሌ', 'ምስል', 'ተጨማሪ መረጃ', 'ገጽ', 'የፊደል ቤት', 'መዝገበ ቃል', ''];
        $maketable = $obj_function->maketable($col);
        foreach ($word_list as $row) {
            $cell = [
                'data' => '<div class="btn-group btn-group-sm">
                <a href="' . base_url('edit') . '/' . $row['word_id'] . '/' . $row['word_meaning_id'] . '" class="btn btn-info"><i class="fa fa-edit"></i></a> </div>',
                'colspan' => 1
            ];
            $cell2 = '';
            if (isset($row['meaning_image']) && !empty($row['meaning_image'])) {
                $cell2 = ['data' =>  '<div class="image">  <img class="img-fluid" src="' . base_url('public/asset/img/dictionary') . '/' . $row['meaning_image'] .
                    '" height= 400px width=286px " alt="Meaning Image"> </div></div>'];
            }
            //$for_del = $row['meaning_id'] . ', ' . $row['word_meaning_id'];
            //$cell3 = '<button type="submit" value="' . $for_del . '" name="del" formmethod="post">Del</button>'; //Delete
            $maketable->addRow(
                $row['row_num'],
                $row['word'],
                $row['short_note'],
                $row['homonyms'],
                $row['meaning'],
                $row['example'],
                $cell2,
                $row['comment'],
                $row['page_no'],
                $row['alphabet_order'],
                $row['short_name'],
                $cell
            );
        }
        $data['table'] = $maketable->generate();
        $data['tags'] = $tagModel->gettags();
        $word_tags = $wordtagModel->getwordtags(['wmt.word_meaning_id' => $wm_id]);
        is_null($word_tags) ? $data['tags_select'][0] = '' : $data['tags_select'] = $word_tags;

        $data['page_cat'] = 'Editors Form';
        $data['page'] = 'Meaning list';

        return $data;
    }
}
