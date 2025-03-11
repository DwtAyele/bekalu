<?php

namespace App\Models;

use CodeIgniter\Model;

class DictionaryAbbrivationModel extends Model
{
    protected $table      = 'dictionary_abbrivation';
    protected $primaryKey = 'dictionary_abbrivation_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //dictionary_abbrivation_Id	word_name	word_abbrivation	dictionary_id	have_POS_id 	flag
    protected $allowedFields = ['word_name', 'word_abbrivation', 'dictionary_id', 'have_POS_id', 'flag'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'word_name' => 'required|string|min_length[2]|max_length[100]',
        'word_abbrivation' => 'required|string|min_length[1]|max_length[7]',
        'dictionary_id' => 'required|is_natural|is_not_unique[dictionary.dictionary_id]',
        'have_POS_id' => 'is_natural|is_not_unique[parts_of_speechs.part_of_speech_id]',
    ];
    protected $validationMessages = [
        'word_name' => [
            'required' => 'Please write the dictionary name.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'word_abbrivation' => [
            'required' => 'Please write short name of dictionary.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'dictionary_id' => [
            'required' => 'select language from.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'have_POS_id' => [
            //'required' => 'select language to',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ]
    ];

    protected $skipValidation     = false;

    public function getdictionaryabbrivations($where = ['flag = ' => 1], $select = ['word_name', 'word_abbrivation'])
    {
        $dictionary = $this->select($select)->orWhere($where)->findAll();
        return array_column($dictionary, 'word_name', 'word_abbrivation');
    }
    public function get_dictionaryabbrivations_byId($where = ['flag = ' => 1], $select = "*")
    {
        $dictionary = $this->select($select)->Where($where)->findAll();
        return $dictionary;
    }
}
