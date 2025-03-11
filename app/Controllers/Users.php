<?php

namespace App\Controllers;

use App\Libraries\Functions;
use App\Libraries\Hash;
use App\Models\UsersModel;

class Users extends BaseController
{
    public $data = [];
    protected $session;
    protected $userModel;

    function __construct()
    {
        //Functions::check_login();
        helper(['form']);
        $this->session = session();
        $this->data = Functions::pagedata();
        $this->userModel = new UsersModel();
    }


    public function index()
    {
        $request = service('request');
        $db = \Config\Database::connect();
        $rules = [
            'email'    => [
                'rules' => 'trim|required|valid_email|min_length[3]|max_length[50]|is_not_unique[users.email,flag,1]',
                'errors' => [
                    'required' => "Email field is required.",
                    'valid_email' => "The Email field must contain a valid email address.",
                    'min_length' => "The Email must be at least 3 characters in length.",
                    'max_length' => "The Email cannot exceed 50 characters in length.",
                    'is_not_unique' => "This email is not registered on our system or deactivated.",
                ],
            ],
            'password' => [
                'rules' => 'trim|required|min_length[4]|max_length[12]',
                'errors' => [
                    'required' => "Password is required.",
                    'min_length' => "The Password must be at least 4 characters in length.",
                    'max_length' => "The Password cannot exceed 12 characters in length.",
                ],
            ],
        ];

        if ($this->session->has('mezegebe_kalat_user_email')) {
            return redirect()->back();
        }
        if (strtolower($request->getMethod()) == 'post' && $this->validate($rules)) {
            // $this->data = array_merge($this->data, ['validation' => Services::validation()]); 'flag' => 1,
            $email = $request->getGetPost('email');
            $passw = $request->getGetPost('password');
            $user_info = $this->userModel->where(['email' => $email,])->first();
            if (!is_null($user_info) && Hash::verifypassword($passw, $user_info['password'])) {
                $username = $user_info['firstname'] . " " . $user_info['lastname'];
                $session_userdata = [
                    'username'  => $username,
                    'mezegebe_kalat_user_email'     => $email,
                    'role_id' => $user_info['role_id'],
                    'dictionary_flag' => $user_info['dictionary_flag'],
                    'logged_in' => true,
                ];
                $this->session->set($session_userdata);
                $this->userModel->where('email = ', $email)->set(['last_login' => date("Y-m-d H:i:s")])->update();
                // $this->data = array_merge($this->data, ['sidebar' => Functions::userrole()]);
                $this->data = Functions::pagedata();
                return view('adminDashbord', $this->data);
            } else {
                $this->session->setFlashData("error_message", "Incorrect password");
                $error_message = $this->session->getFlashdata('error_message');
                $this->data = array_merge($this->data, ['message' => $error_message]);
                return view('login/login', $this->data);
            }
            return view('login/login', $this->data);
        }
        //return redirect()->to('login');
        return view('login/login', $this->data);
    }




    public function register()
    {
        $request = service('request');
        $db = \Config\Database::connect();
        $rules = [
            'password' => [
                'rules' => 'required|min_length[4]|max_length[12]',
                'errors' => [
                    'required' => "Password is required.",
                    'min_length' => "The Password must be at least 4 characters in length.",
                    'max_length' => "The Password cannot exceed 12 characters in length.",
                ],
            ],
        ];
        // get the rules for only the "password" field
        //getValidationRules(['only' => ['password']]) or getValidationRules(['except' => ['image', 'password']])
        $rules = array_merge($rules, $this->userModel->getValidationRules(['only' => ['firstname', 'lastname', 'email', 'retypepassword']]));
        if ($this->session->has('mezegebe_kalat_user_email')) {
            return view('default', $this->data);
        }
        if ($request->getMethod() === 'post' && $this->validate($rules)) {
            $password = Hash::hashpassword(trim($request->getGetPost('password')));
            $userdata = [
                'firstname' => trim($request->getGetPost('firstname')),
                'lastname' => trim($request->getGetPost('lastname')),
                'email' => trim($request->getGetPost('email')),
                'password' => $password,
                'role_id' => 5,
                'flag' => 10,
            ];
            try {
                //$db->table('users')->insert($userdata);
                //$this->userModel->insert($userdata);
                if ($db->table('users')->insert($userdata)) {
                    $this->session->setFlashData("success_message", '<p class="alert alert-success alert-dismissible"><i class="icon fa fa-check"></i> Successfully Registered');
                    $success_message = $this->session->getFlashdata('success_message');
                    $this->data = array_merge($this->data, ['message' => $success_message]);
                    return view('login/register', $this->data);
                }
            } catch (\Exception $e) {
                // exit($e->getMessage()); 
            }
            $this->session->setFlashData("success_message", '<p class="alert alert-danger alert-dismissible"><i class="icon fa fa-ban"></i>Registration Failed');
            $success_message = $this->session->getFlashdata('success_message');
            $this->data = array_merge($this->data, ['message' => $success_message]);
        }
        return view('login/register', $this->data);
    }



    public function forgotpassword()
    {
        $request = service('request');
        $rules = [
            'email'    => [
                'rules' => 'trim|required|valid_email|min_length[3]|max_length[50]|is_not_unique[users.email]',
                'errors' => [
                    'required' => "Email field is required.",
                    'valid_email' => "The Email field must contain a valid email address.",
                    'min_length' => "The Email must be at least 3 characters in length.",
                    'max_length' => "The Email cannot exceed 50 characters in length.",
                    'is_not_unique' => "This email is not registered on our system.",
                ],
            ],

        ];
        if ($this->session->has('mezegebe_kalat_user_email')) {
            return view('default', $this->data);
        }
        if ($request->getMethod() === 'post' && $this->validate($rules)) {
            $email = $request->getGetPost('email');
            $this->session->setFlashData("recoveremail", $email);
            return view('login/recover-password', $this->data);
        }
        return view('login/forgot-password', $this->data);
    }



    public function recoverpassword()
    {
        $request = service('request');
        $rules = $this->userModel->getValidationRules(['only' => ['password', 'retypepassword']]);
        if ($this->session->has('mezegebe_kalat_user_email')) {
            return view('default', $this->data);
        }
        $email = $this->session->getFlashdata('recoveremail');
        if ($request->getMethod() === "post" && $this->validate($rules)  && !is_null($email)) {
            $password = esc(Hash::hashpassword($request->getGetPost('password')));
            $userdata = [
                // 'updated_at' => date("Y-m-d H:i:s"),
                'password' => $password,
                'flag' => 5,
            ];
            $this->userModel->where('email = ', $email)->set($userdata)->update();

            $this->session->setFlashData("success_message", "Password successfully reseted for -{$email}-");
            $success_message = $this->session->getFlashdata('success_message');
            $this->data = array_merge($this->data, ['message' => $success_message]);
        }

        return view('login/recover-password', $this->data);
    }



    public function lockscreen()
    {
        if ($this->session->has('mezegebe_kalat_user_email')) {
            return view('default', $this->data);
        }
        return view('login/lockscreen', $this->data);
    }



    public function profile()
    {
        $request = service('request');
        $rules = $this->userModel->getValidationRules(['only' => ['firstname', 'lastname', 'profilepicture']]);
        if ($this->session->has('mezegebe_kalat_user_email')) {

            $this->data['role'] = $this->data['sidebar'][1][0]["role"];
            $this->data['dictionary_flag'] = $this->data['sidebar'][1][0]["dictionary_flag"];
            $this->data['page_cat'] = 'Users';
            $this->data['page'] = 'profile';
            if ($request->getMethod() == "post" && $this->validate($rules)) {
                $profilepicture = $this->request->getFile('profilepicture'); //'profilepicture'
                $imagename = $profilepicture->getRandomName();
                if ($profilepicture->isValid() && $profilepicture->move('public/asset/img/user/', $imagename)) {
                    $updeatuser = [
                        'firstname' => $request->getGetPost('firstname'),
                        'lastname' => $request->getGetPost('lastname'),
                        'image' => '/public/asset/img/user/' . $imagename,
                    ];
                    $this->userModel->where(['email' => $this->data['email']])->set($updeatuser)->update();
                }

                return redirect()->route('profile', $this->data);
            }
            //$this->data = array_merge($this->data, ['sidebar' => Functions::userrole()]);
            return view('users/profile', $this->data);
        }
        return redirect()->to('login');
        //return view('login/login', $this->data);
    }



    public function signout()
    {
        $this->session->destroy();
        $this->data = Functions::pagedata();
        //  if (!$this->validate([])) {
        //      $this->data = array_merge($this->data, ['validation' => Services::validation()]);
        //$data = ['validation' => Services::validation()];
        //      return view('login/login', $this->data);
        //  }
        return redirect()->to('login');
        //return view('login/login', $this->data);
    }
}
