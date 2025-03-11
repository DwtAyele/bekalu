<?php

namespace App\Models;

use CodeIgniter\Model;

class WordDicAbbrivationModel extends Model
{
    protected $table      = 'word_dic_abbrivation';
    protected $primaryKey = 'word_dic_abbrivation_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //word_dic_abbrivation_id	word_id	dictionary_abbrivation_id	page_no	created_at 	flag
    protected $allowedFields = ['word_id', 'dictionary_abbrivation_id', 'page_no', 'created_at', 'flag'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'word_id' => 'required|is_natural|is_not_unique[words.word_id]',
        'dictionary_abbrivation_id' => 'required|is_natural|is_not_unique[dictionary_abbrivation.dictionary_abbrivation_id]',
        'page_no' => 'required|string|min_length[1]|max_length[7]',
    ];
    protected $validationMessages = [
        'word_id' => [
            'required' => 'word id is required.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid word id',
        ],
        'dictionary_abbrivation_id' => [
            'required' => 'dictionary_abbrivation_id is requierd.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'page_no' => [
            'required' => 'Please write page Number.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ]
    ];

    protected $skipValidation     = false;

    public function set_worddicabb($data)
    {
        $word_dic_abbrivation_id = $this->select('word_dic_abbrivation_id')->where(
            ['word_id' => $data['word_id'], 'dictionary_abbrivation_id' => $data['dictionary_abbrivation_id']]
        )->first();

        if (is_null($word_dic_abbrivation_id)) {
            $this->insert($data);
        } else {
            $this->update($word_dic_abbrivation_id, $data);
        }
    }
}
