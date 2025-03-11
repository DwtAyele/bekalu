<?php

namespace App\Controllers;

use App\Libraries\Functions;
use App\Models\DictionaryModel;
use App\Models\MeaningsModel;

class Dictionary extends BaseController
{

    protected $session;
    function __construct()
    { 
        helper(['form']);
        $this->session = session();
    }

    public function dictionarylist()
    {
        $dic_flag = 1;
        if (!isset($_SESSION['mezegebe_kalat_user_email'])) {
            return redirect()->route('login');
        }
        $dictonarymodel = new DictionaryModel();
        $obj_function = new Functions();

        $dic_flag = session()->get('dictionary_flag');

        $pagedata = $obj_function->pageload();
        $pagedata['page_cat'] = 'Dictionary';
        $pagedata['page'] = 'List';
        //var_dump($pagedata['sidebar'][1][0]["dictionary_flag"]);
        $col = ['#', 'መዝገበ ቃሉ', 'ትርጉሞች', 'ገጽ ብዛት', 'የመጨረሻው ገጽ', 'flage', ''];
        $maketable = $obj_function->maketable($col);

        $SELECT = 'd.short_name, d.flag, d.dictionary_id, COUNT(DISTINCT(wm.word_meaning_id)) AS ትርጉሞች, 
        COUNT(DISTINCT(wm.page_no)) AS ገጽ, MAX(CAST(wm.page_no AS UNSIGNED INTEGER)) AS የመጨረሻው_ገጽ'; //CAST(wm.page_no AS UNSIGNED INTEGER)
        $WHERE = 'd.flag <= ' . $dic_flag;
        $di_list = $dictonarymodel->get_dictionary_data($SELECT, $WHERE)->get()->getResultArray();
        foreach ($di_list as $list) {
            $maketable->addRow(
                $list['row_num'],
                $list['short_name'],
                $list['ትርጉሞች'],
                $list['ገጽ'],
                $list['የመጨረሻው_ገጽ'],
                $list['flag'],
                anchor('dictionarypage/' . $list['dictionary_id'], 'View')
            );
        }
        $maketable->addRow(['', '', '', '', '', '', anchor('addnewdictionary', 'Add New')]);

        $pagedata['table'] = $maketable->generate();

        return view('dictionary/diclist',  $pagedata);
    }

    public function dictionarypage($dic_id = false, $dic_page = false)
    {
        $request = service('request');
        $dic_flag = 1;
        if (!isset($_SESSION['mezegebe_kalat_user_email'])) {
            return redirect()->route('login');
        }
        $dictonarymodel = new DictionaryModel();
        $obj_function = new Functions();

        $dic_flag = session()->get('dictionary_flag');

        $pagedata = $obj_function->pageload();
        $pagedata['page_cat'] = 'Dictionary';
        $pagedata['page'] = 'List';

        $col = ['#', 'መዝገበ ቃሉ', 'ቃላት', 'ትርጉሞች', 'የቃላት ትርጉም', 'ገጽ', '']; //, 'flage', ''

        $SELECT = 'd.short_name,COUNT(DISTINCT(w.word_id)) AS word,COUNT(DISTINCT(wm.word_meaning_id)) AS wordmeaning, COUNT(DISTINCT(m.meaning_id)) AS meaning, wm.page_no, d.dictionary_id'; //, d.flag,d.dictionary_id
        $WHERE = ['d.dictionary_id = ' => $dic_id, 'd.flag <= ' => $dic_flag];
        $GROUPBY = 'wm.page_no';
        $ORDERBY = 'CAST(wm.page_no AS UNSIGNED INTEGER)';
        if (is_numeric($dic_page)) {

            $col = ['#', 'ቃል', 'ሰዋሰው', 'ጠብቆ', 'ትርጉም', 'ምሳሌ', 'ምስል', 'ተጨማሪ መረጃ', 'ገጽ', 'የፊደል ቤት', 'መዝገበ ቃል', '', ''];
            $SELECT = 'w.word, w.short_note, m.homonyms, m.meaning, m.example, m.meaning_image, wm.comment, wm.page_no, m.alphabet_order, d.short_name, w.word_id, wm.word_meaning_id,m.meaning_id';
            $WHERE = ['d.dictionary_id = ' => $dic_id, 'wm.page_no = ' => $dic_page, 'd.flag <= ' => $dic_flag];
            $GROUPBY = 'm.meaning_id,wm.word_meaning_id';
            $ORDERBY = 'w.word_id,m.meaning_id,wm.word_meaning_id';
        }
        $maketable = $obj_function->maketable($col);
        $veiw_data = $dictonarymodel->get_dictionary_data($SELECT, $WHERE, $GROUPBY, $ORDERBY);

        $withlink = $veiw_data->paginate(50);
        $dic_name = '';
        $page_num = 0;
        if (!is_numeric($dic_page)) {
            foreach ($withlink as $list) {
                $row = array(
                    $list['row_num'],
                    $list['short_name'],
                    $list['word'],
                    $list['meaning']
                );
                array_push($row, $list['wordmeaning']);
                array_push($row, $list['page_no'], anchor('dictionarypage/' . $list['dictionary_id'] . '/' . $list['page_no'], 'View'));

                $maketable->addRow($row);
                $dic_name = $list['short_name'];
                $page_num = $list['page_no'];
            }
        } else {
            foreach ($withlink as $list) {
                $row = array(
                    $list['row_num'],
                    $list['word'],
                    $list['short_note'],
                    $list['homonyms'],
                    $list['meaning'],
                    $list['example'],
                    $list['meaning_image'],
                    $list['comment'],
                    $list['page_no'],
                    $list['alphabet_order'],
                    $list['short_name']
                );
                $for_del = $list['meaning_id'] . ', ' . $list['word_meaning_id'];
                $del = '<button class="delete" type="submit" value="' . $for_del . '" name="del" formmethod="post">Del</button>'; //Delete
                array_push($row, anchor('edit/' . $list['word_id'] . '/' . $list['word_meaning_id'], 'Edit'), $del); //,'class="delete"'
                $maketable->addRow($row);
                $dic_name = $list['short_name'];
                $page_num = $list['page_no'];
            }
        }
        $pagedata['data'] = $withlink;
        $pagedata['maketable'] = $maketable;
        $pagedata['pager'] = $veiw_data->pager;
        if (is_numeric($dic_page))
            $pagedata['Breadcrumbs'] = anchor('dictionarypage/' . $dic_id, '  ' . $dic_name) . ' / የገጽ ' . $page_num . ' ትርጉሞች';
        else
            $pagedata['Breadcrumbs'] = anchor('dictionarypage/' . $dic_id, '  ' . $dic_name);

        /**exportcvs */
        if (strtolower($request->getMethod()) === 'post') {
            $meaningModel = new MeaningsModel();
            if (isset($_POST['del'])) {
                $id_ = explode(',', $_POST['del']);
                $meaningModel->deleteMeaning(['m_id' => $id_[0], 'wm_id' => $id_[1]]);
            }
            if (isset($_POST['CSV'])) {
                $cvsdata = $dictonarymodel->get_dictionary_data($SELECT, $WHERE, $GROUPBY, $ORDERBY)->get()->getResultArray();
                $obj_function->exportData($cvsdata, $col, "dictionarypages");
            }
            if (isset($_POST['CSVonlythispage']))
                $obj_function->exportData($pagedata['data'], $col, "dictionarypages");
        }
        return view('dictionary/diclist',  $pagedata);
    }
}
