<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $dateFormat = 'datetime';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['firstname', 'lastname', 'email', 'password', 'role_id', 'dictionary_flag', 'last_login', 'created_at', 'updated_at', 'image', 'flag'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'firstname' => [
            'rules' => 'required|min_length[3]|max_length[12]',
            'errors' => [
                'required' => "First Name is required.",
                'min_length' => "The First Name must be at least 3 characters in length.",
                'max_length' => "The First Name cannot exceed 12 characters in length.",
            ],
        ],
        'lastname' => [
            'rules' => 'required|min_length[3]|max_length[12]',
            'errors' => [
                'required' => "Last Name is required.",
                'min_length' => "The Last Name must be at least 3 characters in length.",
                'max_length' => "The Last Name cannot exceed 12 characters in length.",
            ],
        ],
        'email'    => [
            'rules' => 'required|valid_email|min_length[3]|max_length[50]|is_unique[users.email]',
            'errors' => [
                'required' => "Email field is required.",
                'valid_email' => "The Email field must contain a valid email address.",
                'min_length' => "The Email must be at least 3 characters in length.",
                'max_length' => "The Email cannot exceed 50 characters in length.",
                'is_unique' => "This Email is already registered or deactivated.",
            ],
        ],
        'password' => [
            'rules' => 'required|min_length[4]|max_length[255]',
            'errors' => [
                'required' => "Password is required.",
                'min_length' => "The Password must be at least 4 characters in length.",
                'max_length' => "The Password cannot exceed 12 characters in length.",
            ],
        ],
        'retypepassword' =>  [
            'rules' => 'required|min_length[4]|max_length[12]|matches[password]', //required_with
            'errors' => [
                'required' => "Password is required.",
                'min_length' => "The Password must be at least 4 characters in length.",
                'max_length' => "The Password cannot exceed 12 characters in length.",
                'matches' => "The Retype Password field does not match the password field.",
            ],
        ],
        'role_id' => [
            'rules' => 'permit_empty|is_natural|is_not_unique[roles.role_id]',  
            'errors' => [
                'is_natural' => 'Not valid data',
            ],

        ],
        'dictionary_flag' => [
            'rules' => 'permit_empty|is_natural', //required_with
            'errors' => [
                'is_natural' => 'Not valid data',
            ],

        ],
        'profilepicture' => [
            'rules' => 'permit_empty|uploaded[profilepicture]|is_image[profilepicture]',
            'errors' => [
                'uploaded' => "Image is required.",
                'is_image' => "Uploaded file is not an image.",
            ],
        ],
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
