<?php

namespace App\Models;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $table      = 'language';
    protected $primaryKey = 'language_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //language_id	language_name	abbreviation	flag
    protected $allowedFields = ['language_name', 'abbreviation', 'flag'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'language_name' => 'required|string|min_length[2]|max_length[50]',
        'abbreviation' => 'required|string|min_length[2]|max_length[5]',
    ];
    protected $validationMessages = [
        'language_name' => [
            'required' => 'Please write the language name.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'abbreviation' => [
            'required' => 'Please write the language abbreviation.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ]
    ];

    protected $skipValidation     = false;

    public function getlanguage()
    {
        $languages = $this->select(['language_id', 'language_name'])->where(['flag' => 1])->findAll();
        return array_column($languages, 'language_name', 'language_id');
    }
}
