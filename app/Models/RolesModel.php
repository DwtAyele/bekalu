<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{

    protected $table = 'roles';
    protected $primaryKey = 'role_id';

    protected $dateFormat = 'datetime';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['role', 'comment', 'role_priority'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'role' => 'required|min_length[2]|max_length[12]',
        'comment' => 'permit_empty|string',
        'role_priority' => 'required|is_natural',
    ];
    protected $validationMessages = [
        'role' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'comment' => [
            'string' => 'Not valid data',
        ],
        'role_priority' => [
            'required' => 'Not valid',
            'is_natural' => 'Not valid data',
        ]
    ];

    protected $skipValidation     = false;
}
