<?php

namespace App\Controllers;

use App\Models\WordMeaningModel;
use App\Models\WordMeaningTagsModel;

class Search extends BaseController
{
    protected  $session;
    function __construct()
    {
        helper(['form']);
        //$this->session = session();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $request = service('request');
        $dic_flag = 3;
        if (isset($_SESSION['mezegebe_kalat_user_email'])) {
            $dic_flag = session()->get('dictionary_flag');
        }
        $wordmeaningModel = new WordMeaningModel();
        $wordmeaningtags = new WordMeaningTagsModel();

        if (strtolower($request->getMethod()) === 'post') {

            // $session_for = $this->session->get('__ci_last_regenerate');
            $session_for = $_SESSION['__ci_last_regenerate'];
            if (isset($_POST['like'])) {
                $pagedata['like'] = 'active';
                $id_ = explode(',', $_POST['like']);
                $pagedata['id_'] = $id_[1];
                $wordmeaningModel->word_Meaning_update($id_[1], ['num_like' => intval($id_[0]) + 1]);
            }
            if (isset($_POST['dislike'])) {
                $pagedata['dislike'] = 'active';
                $id_ = explode(',', $_POST['dislike']);
                $pagedata['id_'] = $id_[1];
                $wordmeaningModel->word_Meaning_update($id_[1], ['num_dislike' => intval($id_[0]) + 1]);
            }
            if (isset($_POST['user_report'])) {
                $id_ = explode(',', $_POST['user_report']);
                $wordmeaningModel->word_Meaning_update($id_[1], ['user_report' => intval($id_[0]) + 1]);
            }
        }
        // ->makeLinks($page, 5, 50)
        $groupby = ['word_meaning.word_meaning_id', 'dica.dictionary_abbrivation_Id'];
        $where = ['d.flag <= ' => $dic_flag, 'word_meaning.page_no != ' => '0'];
        $meanings = $wordmeaningModel->getgroupMeanig($where, $groupby, 'w.word', 'RANDOM', 'where'); //'ASC','DESC','RANDOM'
        //$count = $meanings->countAllResults();

        $pagedata = [
            'title' => " የአማርኛ | ማዝገበ ቃላት ",
            'etkalversion' => " ፩.፩.0 ",
            'copyright' => " ፪ ሺ ፲፭ ",
            'short_name' => "<b>ET </b> KAL አስተዳደር",
            'meanings' => $meanings->paginate(10),
            'pager' => $wordmeaningModel->pager,
            'wordtags' => $wordmeaningtags,
            // 'session_for' => $this->session->get('__ci_last_regenerate'),
            'session_for' => $_SESSION['__ci_last_regenerate'],
            'like' => '',
            'dislike' => '',
            'id_' => 0
        ];

        //var_dump($this->session->get());//__ci_last_regenerate
        //var_dump($this->session->get('__ci_last_regenerate')); //__ci_last_regenerate
        return view('search/search', $pagedata);
    }

    public function searchword($searchword = '', $wm_id = 0)
    {
        $request = service('request');
        $wordmeaningModel = new WordMeaningModel();
        $rules = [
            'searctext' => [
                'rules' => 'string|min_length[1]|max_length[100]',
                'errors' => [
                    'string' => 'Not valid type',
                    'min_length' => 'To Short.',
                    'max_length' => 'To long.',
                ],
            ],
        ];
        //$searchword = $request->getGet('searctext');
        $word['w.word'] = $searchword;
        //$this->validateData([$this->request->getGet('searctext')],$rules);
        $_POST['searctext'] = $this->request->getGet('searctext');

        if (strtolower($request->getMethod()) === 'get' && $this->validate($rules) && !is_null($this->request->getGet('searctext'))) {
            $searchword = trim($_POST['searctext']);
            $word['w.word'] = $searchword;
            !is_null($this->request->getGet('wm_id')) ? $word['word_meaning.word_meaning_id'] = $this->request->getGet('wm_id') : '';
        }
        if (strtolower($request->getMethod()) === 'post' && $this->validate($rules) && !is_null($this->request->getGet('searctext'))) {
            $searchword = trim($_POST['searctext']);
            $word['w.word'] = $searchword;
            !is_null($this->request->getGet('wm_id')) ? $word['word_meaning.word_meaning_id'] = $this->request->getGet('wm_id') : '';
        }
        if (strtolower($request->getMethod()) === 'post') {
            if (isset($_POST['like'])) {
                $pagedata['like'] = 'active';
                $id_ = explode(',', $_POST['like']);
                $pagedata['id_'] = $id_[1];
                $wordmeaningModel->word_Meaning_update($id_[1], ['num_like' => intval($id_[0]) + 1]);
            }
            if (isset($_POST['dislike'])) {
                $pagedata['dislike'] = 'active';
                $id_ = explode(',', $_POST['dislike']);
                $pagedata['id_'] = $id_[1];
                $wordmeaningModel->word_Meaning_update($id_[1], ['num_dislike' => intval($id_[0]) + 1]);
            }
            if (isset($_POST['user_report'])) {
                $id_ = explode(',', $_POST['user_report']);
                $wordmeaningModel->word_Meaning_update($id_[1], ['user_report' => intval($id_[0]) + 1]);
            }
        }
        $word['word_meaning.page_no != '] = '0'; // 
        $word['m.meaning_id != '] = 1;
        $pagedata = $this->find_word($word);

        //return redirect()->route('kalat', $pagedata);
        return view('search/search2', $pagedata);
    }

    public function find_word($word_tofind)
    {
        $email = null;
        $dic_flag = 3;
        if (isset($_SESSION['mezegebe_kalat_user_email'])) {
            $email = session()->get('mezegebe_kalat_user_email');
            $word_tofind['u.email'] = $email;
            $dic_flag = session()->get('dictionary_flag');
        }
        $word_tofind['d.flag <= '] = $dic_flag;
        $wordmeaningModel = new WordMeaningModel();
        $groupby = ['word_meaning.word_meaning_id', 'dica.dictionary_abbrivation_Id'];
        $result = (array)$wordmeaningModel->getgroupMeanig($word_tofind, $groupby, 'w.word', 'ASC', 'where')->get()->getResult(); //ASC RANDOM
        if (count($result) == 0) {
            $sec_serch['d.flag <= '] = $word_tofind['d.flag <= '];
            $for_like = $word_tofind['w.word'];
            $result = (array)$wordmeaningModel->getgroupMeanig($sec_serch, $groupby, 'w.word', 'ASC', 'where', $for_like)->get()->getResult();
        }
        if (count($result) == 1) {
            $sec_serch['d.flag <= '] = $word_tofind['d.flag <= '];
            $sec_serch['word_meaning.word_meaning_id != '] = $result[0]->word_meaning_id;
            $for_like = $word_tofind['w.word'];
            $result2 = (array)$wordmeaningModel->getgroupMeanig($sec_serch, $groupby, 'w.word', 'ASC', 'where', $for_like)->get()->getResult();
            $result = array_merge($result, $result2);
        }
        if ($this->count_unicode_words($word_tofind['w.word']) > 1) {
            $sec_serch['d.flag <= '] = $word_tofind['d.flag <= '];

            $for_like = preg_split("/[\s,]+/", $word_tofind['w.word'])[0];
            $result2 = (array)$wordmeaningModel->getgroupMeanig($sec_serch, $groupby, 'w.word', 'ASC', 'where', $for_like)->get()->getResult();
            $result = array_merge($result, $result2);

            $for_like = preg_split("/[\s,]+/", $word_tofind['w.word'])[1];
            $result2 = (array)$wordmeaningModel->getgroupMeanig($sec_serch, $groupby, 'w.word', 'ASC', 'where', $for_like)->get()->getResult();
            $result = array_merge($result, $result2);
        }
        $wordmeaningtags = new WordMeaningTagsModel();
        $pagedata = [
            'title' => " የአማርኛ | ማዝገበ ቃላት ",
            'etkalversion' => " ፩.፩.0 ",
            'copyright' => " ፪ ሺ ፲፭ ",
            'short_name' => "<b>ET </b> KAL አስተዳደር",
            'meanings' => $result,
            'wordtags' => $wordmeaningtags,
            'session_for' => $this->session->get('__ci_last_regenerate'),
            'like' => '',
            'dislike' => '',
            'id_' => 0
        ];
        return $pagedata;
    }
    function count_unicode_words($unicode_string)
    {
        // First remove all the punctuation marks & digits
        $unicode_string = preg_replace('/[[:punct:][:digit:]]/', '', $unicode_string);
        // Now replace all the whitespaces (tabs, new lines, multiple spaces) by single space
        $unicode_string = preg_replace('/[[:space:]]/', ' ', $unicode_string);
        // The words are now separated by single spaces and can be splitted to an array
        // I have included \n\r\t here as well, but only space will also suffice
        $words_array = preg_split("/[\n\r\t ]+/", $unicode_string, 0, PREG_SPLIT_NO_EMPTY);
        // Now we can get the word count by counting array elments
        return count($words_array);
    }
}
