<?php

namespace App\Models;

use CodeIgniter\Model;

class AlternativewordwritingsModel extends Model
{
    protected $table      = 'alternative_word_writings';
    protected $primaryKey = 'Alternative_word_writing_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['main_word_id', 'alternative_word_id', 'flag'];

    // protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'main_word_id' => 'required|is_natural|is_not_unique[words.word_id]',
        'alternative_word_id' => 'required|is_natural|is_not_unique[words.word_id]',
    ];
    protected $validationMessages = [
        'main_word_id' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'alternative_word_id' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ]
    ];

    protected $skipValidation     = false;

    public function insert_alternative_word_writings($in_Data, $flag = 5)
    {
        $data = array_intersect_key($in_Data, array_flip($this->allowedFields));
        $data['flag'] = $flag;
        $alternative_word_writing_id = $this->insert($data);

        return $alternative_word_writing_id;
    }
}
