<?php

namespace App\Controllers;

use App\Libraries\Functions;

class Home extends BaseController
{

    protected $session;
    function __construct()
    {
        Functions::check_login();
        helper(['form']);
        $this->session = session();
    }

    public function index()
    {
        if (!$this->session->has('mezegebe_kalat_user_email')) {
            $this->session->destroy();
            return redirect()->to('login');
        } elseif ($this->session->has('mezegebe_kalat_user_email')) {
            return view('adminDashbord', Functions::pagedata());
        } else {
            return redirect()->route('login/login', Functions::pagedata());
        }
    }
    public function mywiki()
    {
        if (!$this->session->has('mezegebe_kalat_user_email')) {
            $this->session->destroy();
            return redirect()->to('login');
        } elseif ($this->session->has('mezegebe_kalat_user_email')) {
            return   view('/wiki/mywiki.html'); //base_url('public/wiki/mywiki.html');//public/asset/img/user/
        } else {
            return redirect()->route('login/login', Functions::pagedata());
        }
    }
}
