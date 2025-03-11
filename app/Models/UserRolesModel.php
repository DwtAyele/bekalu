<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRolesModel extends Model
{

    protected $table = 'user_roles';
    protected $primaryKey = 'user_role_id';

    protected $dateFormat = 'datetime';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_id', 'role_action_id', 'role_page_id', 'comment', 'created_at', 'updated_at', 'expiry_date', 'flag'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'user_id' => 'required|is_natural|is_not_unique[users.user_id]',
        'role_action_id' => 'required|is_natural|is_not_unique[role_action.role_action_id]',
        'role_page_id' => 'required|is_natural|is_not_unique[role_action.role_page_id]',
        'comment' => 'permit_empty|string',
    ];
    protected $validationMessages = [
        'user_id' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'role_action_id' => [
            'required' => 'Not valid dictionary_id',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'role_page_id' => [
            'required' => 'Not valid dictionary_id',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'comment' => [
            'string' => 'Not valid data',
        ]
    ];

    protected $skipValidation     = false;
}
