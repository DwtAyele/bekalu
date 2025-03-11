<?php

namespace App\Libraries;

use App\Models\DictionaryModel;
use App\Models\LanguageModel;
use App\Models\PartsofSpeechsModel;
use App\Models\TagsModel;
use Config\Services;

use App\Models\UsersModel;

class Functions
{
    public $session;
    function __construct($session = null)
    {
        $this->session = session();
    }
    public static function check_login()
    {
        $session = session();
        if (!$session->has('mezegebe_kalat_user_email')) {
            return redirect()->to('login');
        } else {
            return redirect()->back();
        }
    }

    public static function pagedata()
    {
        // Functions::check_login();
        $userModel = new UsersModel();
        $request = service('request');
        $short_name = "<b>ET </b> KAL";
        $userdata = array();
        if (!is_null($request->getGetPost('email'))) {
            $temp = $userModel->where(['email' => $request->getGetPost('email')])->find(); //$request->getGetPost('email') 
            foreach ($temp as $ud) {
                $userdata = $ud;
            }
        }
        $arraydata = [
            'title' => " የአማርኛ | ማዝገበ ቃላት ",
            'etkalversion' => " ፩.፪.0 ", //3/9/2023 
            'copyright' => " ፪ ሺ ፲፭ ",

            'short_name' => "{$short_name} አስተዳደር",
            'breand_text' => "{$short_name} - የቃል አስተዳደር",

            'login_box_msg' => "Sign in to {$short_name} Admin Page",

            'page_cat' => '',
            'page' => '',
            'isactiv' => ' class="nav-link active"',
            'notactiv' => ' class="nav-link"',

            'validation' => Services::validation(),

        ];
        if (!is_null($userdata)) {
            $temp = $userModel->where(['email' => session()->get('mezegebe_kalat_user_email')])->find(); //or  session()->get('email')]
            foreach ($temp as $ud) { //$_SESSION['mezegebe_kalat_user_email']
                $userdata = $ud; //session()->get('mezegebe_kalat_user_email')
            }
        }
        // array_push($arraydata, $userdata, ['sidebar' => Functions::userrole()]);
        $return[0] = Functions::userrole();
        if (isset($return[0])) {
            $return[1] = Functions::unique_multidim_array($return[0], 'category'); //page_category_id or category

        } else {
            $return = null;
        }
        return array_merge($arraydata, $userdata, ['sidebar' => $return]);
    }

    public static function userrole()
    {
        if (!isset($_SESSION['mezegebe_kalat_user_email'])) {
            //return redirect()->route('login');
            return null;
        }
        $db = db_connect();
        // $db->reconnect();
        $builder = $db->table('user_roles AS ur');
        $builder->select('pc.page_category_id, pc.category, pc.link, pc.icon, pc.view_order, pc.sefix_html, 
        p.page, p.page_link, p.page_icon, p.page_view_order, p.page_sefix, p.category_id, 
        r.role, u.role_id, u.dictionary_flag');

        //$builder->join('role_actions AS ra', 'ur.role_action_id = ra.role_action_id');
        $builder->join('rolepage AS rp', 'ur.role_page_id = rp.rolepage_id');
        $builder->join('pages AS p', 'rp.page_id = p.page_id');
        $builder->join('page_categories AS pc', 'p.category_id = pc.page_category_id');
        $builder->join('roles AS r', 'rp.role_id = r.role_id');
        // $builder->join('user_roles AS ur', 'ur.user_id = u.user_id');
        $builder->join('users AS u', 'ur.user_id = u.user_id');

        $where = [
            'u.email' => $_SESSION['mezegebe_kalat_user_email'], 'ur.flag' => 1, 'p.flag' => 1,
            'pc.flag' => 1, 'ur.expiry_date >= CURRENT_DATE() OR ur.expiry_date IS NULL'
        ];
        $builder->where($where);

        $builder->groupBy(['p.page_id', 'r.role_id']); //, 'u.role_id','ur.user_id'
        $builder->orderBy('pc.view_order ASC, p.page_view_order ASC');

        $return = $builder->get()->getResultArray();
        // var_dump($return[0]['dictionary_flag']);
        $session = session();
        $session->set('dictionary_flag', $return[0]['dictionary_flag']);
        $session->set('role_id', $return[0]['role_id']);
        // $query = $builder->get();
        // $return[0] = $query->getResultArray(); 

        //$return[1] = Functions::unique_multidim_array($return[0], 'category'); //page_category_id or category
        return $return;
    }


    public static function unique_multidim_array($array, $key) //array_column()
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
                //$temp_array[$i] = $val['category'];
            }
            $i++;
        }
        return $temp_array;
    }
    public function pageload($flag = ['flag <= ' => 1])
    {
        $lanModel = new LanguageModel();
        $tagModel = new TagsModel();
        $dicModel = new DictionaryModel();
        $posModel = new PartsofSpeechsModel();

        $pagedata = Functions::pagedata();

        $data['languages']  = $lanModel->getlanguage();
        $data['dictionary'] = $dicModel->getdictionarys($flag);
        $data['part_of_speech'] = $posModel->getpartsofspeechs();

        $data['is_list'] = implode(",", array_keys($data["languages"]));
        $data['languages'][0]  = 'Please select';
        $data['dictionary'][0]  = 'Please select';
        $data['part_of_speech'][0]  = 'Please select';
        //$tags = $this->request->getPost('tag');
        //is_null($tags) ? $data['tags_select'][0] = '' : $data['tags_select'] = $tags;
        $data['accessibility'] = ['0' => '--የቃሉ ተደራሽነት--', 'በጣም የተለመደ' => 'በጣም የተለመደ', 'የተለመደ' => 'የተለመደ', 'አልፎ አልፎ ጥቅም ላይ የሚውል' => 'አልፎ አልፎ ጥቅም ላይ የሚውል', 'የማይታወቅ' => 'የማይታወቅ',];
        $data['error'] = array();
        ksort($data['languages']);
        ksort($data['part_of_speech']);
        return array_merge($pagedata, $data);
    }
    public function getrules($data)
    {
        $rules = [
            'word' => [
                'rules' => 'required|string|min_length[1]|max_length[60]',
                'errors' => [
                    'required' => 'Please write the word.',
                    'string' => 'Not valid type',
                    'min_length' => 'To Short.',
                    'max_length' => 'To long.',
                ],
            ],
            'languagefrom'    => [
                'rules' => "required|in_list[$data]",
                'errors' => [
                    'in_list' => 'Please select language.',
                ],
            ],
            'languageto' => [
                'rules' => "required|in_list[$data]",
                'errors' => [
                    'in_list' => 'Please select language.',
                ],
            ],
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,csv]',
                'errors' => [
                    'uploaded' => 'Please upload file, Not a valid type',
                    'ext_in' => 'Please upload CSV file.',
                ],
            ],
            'noofrows' => [
                'rules' => 'required|is_natural',
                'errors' => [
                    'required' => 'Pleas enter number of row',
                    'is_natural' => 'Pleas enter a valid number.',
                ],
            ]
        ];
        return $rules;
    }
    public function maketable($header = ['#', 'ቃሉ', 'ሰዋሰው', 'ትርጉሙ', 'ምሳሌ', 'ተጨማሪ ማብራሪያ', 'ምስል አለው'])
    {
        $table = new \CodeIgniter\View\Table();
        $template = [
            'table_open' => '<table class="table table-bordered table-hover" border="1" cellpadding="4" cellspacing="0">',

            'thead_open'  => '<thead>',
            'thead_close' => '</thead>',

            'heading_row_start'  => '<tr>',
            'heading_row_end'    => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end'   => '</th>',

            'tfoot_open'  => '<tfoot>',
            'tfoot_close' => '</tfoot>',

            'footing_row_start'  => '<tr>',
            'footing_row_end'    => '</tr>',
            'footing_cell_start' => '<td>',
            'footing_cell_end'   => '</td>',

            'tbody_open'  => '<tbody>',
            'tbody_close' => '</tbody>',

            'row_start'  => '<tr>',
            'row_end'    => '</tr>',
            'cell_start' => '<td>',
            'cell_end'   => '</td>',

            'row_alt_start'  => '<tr>',
            'row_alt_end'    => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end'   => '</td>',

            'table_close' => '</table>',
        ];
        $table->setHeading($header);
        $table->setTemplate($template);
        //$table->setEmpty('&nbsp;');

        return $table;
    }

    public function exportData($data, $header, $name = "መዝገበቃላት_")
    {
        // file name 
        $filename = $name . date('Ymdhms') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // file creation 
        $file = fopen('php://output', 'w');

        // $header = array("ID","Name","Email","City"); 
        fputcsv($file, $header);
        foreach ($data as $key => $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }
}
