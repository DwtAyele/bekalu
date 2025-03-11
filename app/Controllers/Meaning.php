<?php

namespace App\Controllers;

use App\Libraries\Functions;
use App\Models\AlternativewordwritingsModel;
use App\Models\DictionaryAbbrivationModel;
use App\Models\DictionaryAlphabetOrdersModel;
use App\Models\DictionaryModel;
use App\Models\LanguageModel;
use App\Models\MeaningsModel;
use App\Models\PartsofSpeechsModel;
use App\Models\TagsModel;
use App\Models\WordDicAbbrivationModel;
use App\Models\WordsModel;
use App\Models\WordMeaningModel;
use App\Models\WordMeaningTagsModel;

class Meaning extends BaseController
{

    protected $session;

    function __construct()
    {
        helper(['form']);
        $this->session = session();
    }

    public function index()
    {
        /*  if (!$this->session->has('mezegebe_kalat_user_email')) {
            return redirect()->route('login');
        }
        $data = $this->pageload(['flag <= ' => $dic_flag = session()->get('dictionary_flag')]);
        return view('dictionary/addmeaning', $data); */
    }
    public function addmeaning()
    {
        if (!$this->session->has('mezegebe_kalat_user_email')) {
            return redirect()->route('login');
        }

        $meaningModel = new MeaningsModel();
        $wordModel = new WordsModel();
        $wordmeaningModel = new WordMeaningModel();
        $tagModel = new TagsModel();
        $wordmeaningTagModel = new WordMeaningTagsModel();

        $request = service('request');
        $data = $this->pageload(['flag <= ' => $dic_flag = $_SESSION['dictionary_flag']]); //$_SESSION['dictionary_flag']  session()->get('dictionary_flag')

        $getrules = new Functions();
        $rules = array_intersect_key($getrules->getrules($data['is_list']), ['word' => '', 'languagefrom' => '', 'languageto' => '']);
        $rules = array_merge(
            $rules,
            $meaningModel->getValidationRules(['only' => ['meaning']]), //, 'meaning_image'
            $wordModel->getValidationRules(['only' => ['accessibility']]), //'word', 
            $wordmeaningModel->getValidationRules(['only' => ['dictionary_id']]), //'word Meaning',
            // $tagModel->getValidationRules(['only' => ['tag']]),
        );
        if (strtolower($request->getMethod()) === 'post' && $this->validate($rules)) {
            $word = $this->request->getPost('word');
            $homonym =  $this->request->getPost('homonyms') ? 'ጠብቆና ላልቶ የሚነበብ' : null; //array(1) { [0]=> string(3) "Yes"} 'Yes' : 'No'
            $meaning = $this->request->getPost('meaning');
            $example = $this->request->getPost('example');
            $languagefrom = $this->request->getPost('languagefrom');
            $languageto = $this->request->getPost('languageto');
            $accessibility = $this->request->getPost('accessibility');
            $dictionary = $this->request->getPost('dictionary_id');
            $part_of_speech = $this->request->getPost('part_of_speech');
            $tags = $this->request->getPost('tag');
            $meaning_image = $this->request->getFile('meaning_image');

            $inputdata = [
                'word' => $word, 'pronunciation' => '', 'accessibility' => $accessibility,  'languagefrom' => intVal($languagefrom), 'short_note' => '',
                'meaning' => $meaning, 'example' => $example, 'homonyms' => $homonym, 'part_of_speech_id' => $part_of_speech > 0 ? $part_of_speech : null, 'languageto' => intVal($languageto), 'meaning_image' => '',
                'mflag' => '', 'dictionary_id' => $dictionary, 'page_no' => '0', 'comment' => '', 'user_report' => '', 'tags' => $tags,  'user_id' => intVal($data['user_id'])
            ];

            $imagename = $meaning_image->getRandomName();
            if ($meaning_image->isValid() && $meaning_image->move('public/asset/img/dictionary/', $imagename)) {
                //$meaning_image->move('public/asset/img/dictionary/', $imagename); 
                $inputdata['meaning_image'] = $imagename;
            }

            $inputdata['word_id'] = $wordModel->set_insert_word($inputdata);
            $inputdata['meaning_id'] =  $meaningModel->set_insert_meanings($inputdata);
            $inputdata['word_meaning_id'] = $wordmeaningModel->toinsert_word_meaning($inputdata);

            if (!is_null($inputdata['tags'])) {
                $inputdata['tag_id'] = $tagModel->insert_tag($inputdata);
                $wordmeaningTagModel->insert_word_meaning_tags($inputdata);
            }
            $data['tags'] = $tagModel->gettags($data['user_id']); //to relode user tags;
            is_null($inputdata['tags']) ? $data['tags_select'][0] = '' : $data['tags_select'] = $inputdata['tag_id'];

            //$data = $this->pageload();
            $data['meaning_message'] = '<b>' . $word . '</b> - ትርጉሙ ተመዝግቧል! ';
            //return redirect()->route('addmeaning', $data);
        }
        return view('dictionary/addmeaning', $data);
    }
    function wordmeaninglist()
    {
        // if (!$this->session->has('mezegebe_kalat_user_email')) {
        //  return redirect()->route('login');
        //  }
        if (empty($_SESSION['mezegebe_kalat_user_email'])) {
            return redirect()->route('login');
        }
        $pagedata = $this->pageload(['flag <= ' => $dic_flag = $_SESSION['dictionary_flag']]);
        $request = service('request'); //$_SESSION['dictionary_flag']
        $wordmeaningModel = new WordMeaningModel();
        $wordmeaningtags = new WordMeaningTagsModel();
        $obj_function = new Functions();
        $Dicalphabet_order = new DictionaryAlphabetOrdersModel();
        $pagedata['alphabet_order'] = $Dicalphabet_order->get_dictionaryalphabetorder_groupdropdown();
        //$rules =   $wordmeaningModel->getValidationRules(['only' => ['dictionary_id']]); //'word Meaning', 
        $match = ['word_meaning.word_meaning_id >' => 0];

        if (strtolower($request->getMethod()) === 'post') { //&& $this->validate($rules)
            $word = $this->request->getPost('word');
            $dictionary = $this->request->getPost('dictionary_id');
            $pagenumber = $this->request->getPost('pagenumber');
            $alphabet_order = $this->request->getPost('alphabet_order');
            empty($word) ? null : $match['w.word'] = trim($word);
            empty($dictionary) ? null : $match['d.dictionary_id'] =  $dictionary;
            empty($pagenumber) ? null : $match['word_meaning.page_no'] =  $pagenumber;
            empty($alphabet_order) ? null : $match['m.alphabet_order'] =  $alphabet_order;
            //var_dump($match);
        }
        $groupby = ['word_meaning.word_meaning_id', 'dica.dictionary_abbrivation_Id'];
        $veiw_data = $wordmeaningModel->getgroupMeanig($match, $groupby, 'w.word', 'asc', 'WHERE');
        //asort($veiw_data); 
        $word_ListData = $veiw_data->paginate(50);
        $wordmeanings = [
            'meanings' =>  $word_ListData, //ASC DESC
            'pager' => $wordmeaningModel->pager,
            'wordtags' => $wordmeaningtags,
        ];

        //$pagedata['Breadcrumbs'] = 'Word Meaning List';
        $pagedata['page_cat'] = 'Editors Form';
        $pagedata['page'] = 'Meaning list';

        $SELECT = 'w.word, w.short_note, m.homonyms, m.meaning, m.example, m.meaning_image, word_meaning.comment, word_meaning.page_no, m.alphabet_order, d.short_name, word_meaning.word_meaning_id';
        $col = ['#', 'ቃል', 'ሰዋሰው', 'ጠብቆ', 'ትርጉም', 'ምሳሌ', 'ምስል', 'ተጨማሪ መረጃ', 'ገጽ', 'የፊደል ቤት', 'መዝገበ ቃል'];
        /**exportcvs */
        if (strtolower($request->getMethod()) === 'post') {

            if (isset($_POST['CSV'])) {
                $cvsdata = $wordmeaningModel->getgroupMeanig($match, $groupby, 'w.word', 'asc', 'WHERE', null, 0, $SELECT)->get()->getResult('array');
                $obj_function->exportData($cvsdata, $col, "ትርጉሞች");
            }
            if (isset($_POST['CSVonlythispage']))
                $obj_function->exportData($veiw_data->get(100)->getResult('array'), $col, "ትርጉሞች");
        }
        return view('dictionary/wordmeaninglist', array_merge($wordmeanings, $pagedata));
    }

    function importdata()
    {
        if (!$this->session->has('mezegebe_kalat_user_email')) {
            return redirect()->route('login');
        }
        $data = $this->pageload(['flag <= ' => $dic_flag = $_SESSION['dictionary_flag']]);
        $request = service('request');
        $data['page_cat'] = 'Editors Form';
        $data['page'] = 'Import';
        $data['csv'] = '';

        $getrules = new Functions();
        $wordmeaningModel = new WordMeaningModel();

        $rules = array_intersect_key($getrules->getrules($data['is_list']), ['file' => '', 'noofrows' => '']);
        $rules = array_merge(
            $rules,
            $wordmeaningModel->getValidationRules(['only' => ['dictionary_id']]) //'word Meaning', 
        );
        if (strtolower($request->getMethod()) === 'post' && $this->validate($rules)) {

            $numberOfFields = $this->request->getPost('numberOfFields');
            $noofrows = $this->request->getPost('noofrows');
            $dictionary = $this->request->getPost('dictionary_id');
            $excelfile = $this->request->getFile('file');

            $filename = $excelfile->getRandomName();
            if ($excelfile->isValid() && !$excelfile->hasMoved()) {
                $excelfile->move('public/asset/import/', $filename);

                $relative_path = 'public/asset/import/' . $filename;

                $dictionaryModel = new DictionaryModel();
                $dicLan = $dictionaryModel->get_dictionary_byId(
                    ['dictionary_id' => $dictionary, 'flag <= ' => 11],
                    ['dictionary_language_from', 'dictionary_language_to']
                )[0];

                $inputdata['numberOfFields'] = $numberOfFields;
                $inputdata['noofrows'] = $noofrows;
                $inputdata['languagefrom'] = $dicLan['dictionary_language_from'];
                $inputdata['languageto'] = $dicLan['dictionary_language_to'];
                $inputdata['dictionary_id'] = $dictionary;
                $inputdata['user_id'] = $data['user_id'];

                $csvdata = $this->importcsvfile($relative_path, $inputdata);
                $words['word'] = array_column($csvdata, 'ቃሉ');
                $table = new Functions();
                $maketable = $table->maketable(['#', 'ቃሉ', 'የተለየ አጻጻፍ', 'ሰዋሰው','ጠብቆ-ላልቶ', 'ትርጉሙ', 'ምሳሌ', 'ተጨማሪ ማብራሪያ', 'ምስል አለው', 'የፊደል ቤቱ', 'ገጽ']);
                $data['csv'] = $maketable->generate($csvdata);
            }
        }
        return view('dictionary/import',  $data);
    }

    function importcsvfile($relative_path, $inputdata)
    {
        $wordModel = new WordsModel();
        $meaningModel = new MeaningsModel();
        $wordmeaningModel = new WordMeaningModel();
        $dicLanabbrivationModel = new DictionaryAbbrivationModel();
        $worddicAbbrivationModel = new WordDicAbbrivationModel();
        $alternativewordwritingsModel = new AlternativewordwritingsModel();

        $dicabbr = $dicLanabbrivationModel->get_dictionaryabbrivations_byId(['dictionary_id' => $inputdata['dictionary_id']]);
        $dicabbr = array_column($dicabbr, 'word_abbrivation', 'dictionary_abbrivation_id');
        $file = fopen($relative_path, "r");
        $i = 0;
        $j = 1;
        $pagenum = 0;
        $alphabet_order = null;
        $csvArr = array();
        while (($filedata = fgetcsv($file, $inputdata['noofrows'], ",")) !== FALSE) {
            $num = count($filedata);
            if ($i > 0 && $num == $inputdata['numberOfFields']) {

                if (!is_null($filedata[0]) && !empty($filedata[0])) {

                    $csvArr[$i]['#'] = $j;
                    $csvArr[$i]['ቃሉ'] = $filedata[0];
                    $csvArr[$i]['ቃሉ2'] = $filedata[1];
                    $csvArr[$i]['ሰዋሰው'] = $filedata[2];
                    $csvArr[$i]['homonyms'] = $filedata[3];
                    $csvArr[$i]['ትርጉሙ'] = $filedata[4];
                    $csvArr[$i]['ምሳሌ'] = $filedata[5];
                    $csvArr[$i]['ተጨማሪ ማብራሪያ'] = $filedata[6];
                    $csvArr[$i]['ምስል አለው'] = $filedata[7];
                    $csvArr[$i]['የፊደል ቤቱ'] = $filedata[8];
                    $csvArr[$i]['ገጽ'] = $filedata[9];

                    $inputdata['word'] = trim($csvArr[$i]['ቃሉ']);
                    $inputdata['word2'] = trim($csvArr[$i]['ቃሉ2']);
                    $inputdata['short_note'] = trim($csvArr[$i]['ሰዋሰው']);
                    $inputdata['homonyms'] = trim($csvArr[$i]['homonyms']);
                    $inputdata['meaning'] = trim($csvArr[$i]['ሰዋሰው']) . ' :-  ' . trim($csvArr[$i]['ትርጉሙ']);
                    $inputdata['example'] = trim($csvArr[$i]['ምሳሌ']);
                    $inputdata['comment'] = trim($csvArr[$i]['ተጨማሪ ማብራሪያ']) . '  ምስል => ' . trim($csvArr[$i]['ምስል አለው']);
                    $inputdata['alphabet_order'] = trim($csvArr[$i]['የፊደል ቤቱ']);
                    $inputdata['page_no'] = trim($csvArr[$i]['ገጽ']);

                    if (is_numeric($inputdata['word'])) {
                        $pagenum = $inputdata['word'];
                    } else {
                        $inputdata['word_id'] = $wordModel->set_insert_word($inputdata);
                        if (!empty($inputdata['page_no']) && !isset($inputdata['page_no'])) {
                            $inputdata['page_no'] = $pagenum;
                            $csvArr[$i]['ገጽ'] = $pagenum;
                        }
                    }
                    empty($inputdata['alphabet_order']) ? $inputdata['alphabet_order'] = $alphabet_order : $alphabet_order = $inputdata['alphabet_order'];
                    if (!empty($inputdata['meaning'])) {
                        $inputdata['meaning_id'] =  $meaningModel->set_insert_meanings($inputdata);
                        $inputdata['word_meaning_id'] = $wordmeaningModel->toinsert_word_meaning($inputdata);
                    }
                    if (!empty($inputdata['word2'])) {
                        $in_Data = ['word' => $inputdata['word2'], 'languagefrom' => $inputdata['languagefrom']];
                        $inputdata['word_id2'] = $wordModel->set_insert_word($in_Data);

                        $alternativewordwritingsModel->insert_alternative_word_writings(['main_word_id' => $inputdata['word_id'], 'alternative_word_id' => $inputdata['word_id2']]);
                    }
                    if (in_array($inputdata['short_note'], $dicabbr, TRUE)) {
                        $temp = array_keys($dicabbr, $inputdata['short_note'])[0] + 1;
                        $worddicAbbrivationModel->set_worddicabb(['word_id' => intVal($inputdata['word_id']), 'dictionary_abbrivation_id' => $temp, 'page_no' => $inputdata['page_no']]);
                    }
                    $j++;
                }
            }
            $i++;
        }
        fclose($file);
        return $csvArr;
    }

    function pageload($flag = ['flag <= ' => 1])
    {
        $lanModel = new LanguageModel();
        $tagModel = new TagsModel();
        $dicModel = new DictionaryModel();
        $posModel = new PartsofSpeechsModel();

        $pagedata = Functions::pagedata();
        $pagedata['page_cat'] = 'Editors Form';
        $pagedata['page'] = 'Add Meaning';

        $data['languages']  = $lanModel->getlanguage();
        $data['tags'] = $tagModel->gettags($pagedata['user_id']);
        $data['dictionary'] = $dicModel->getdictionarys($flag);
        $data['part_of_speech'] = $posModel->getpartsofspeechs();

        $data['is_list'] = implode(",", array_keys($data["languages"]));
        $data['languages'][0]  = 'Please select';
        $data['dictionary'][0]  = 'Please select';
        $data['part_of_speech'][0]  = 'Please select';
        $tags = $this->request->getPost('tag');
        is_null($tags) ? $data['tags_select'][0] = '' : $data['tags_select'] = $tags;
        $data['accessibility'] = ['0' => '--የቃሉ ተደራሽነት--', 'በጣም የተለመደ' => 'በጣም የተለመደ', 'የተለመደ' => 'የተለመደ', 'አልፎ አልፎ ጥቅም ላይ የሚውል' => 'አልፎ አልፎ ጥቅም ላይ የሚውል', 'የማይታወቅ' => 'የማይታወቅ',];
        $data['error'] = array();
        ksort($data['languages']);
        ksort($data['dictionary']);
        ksort($data['part_of_speech']);
        return array_merge($pagedata, $data);
    }
}
