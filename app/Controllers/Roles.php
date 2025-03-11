<?php

namespace App\Controllers;

use App\Libraries\Functions;
use App\Models\DictionaryModel;

class Roles extends BaseController
{
    protected $session;
    public function __construct()
    {
       // Functions::check_login();
        helper(['form']);
        $this->session = session();
    }
    public function userlist()
    {
        if (!$this->session->has('mezegebe_kalat_user_email')) {
            return redirect()->route('login');
        }
        $obj_function = new Functions();
        $pagedata = $obj_function->pageload();
        $pagedata['page_cat'] = 'Dictionary';
        $pagedata['page'] = 'List';
    }
}
