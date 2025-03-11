<?php

namespace App\Models;

use CodeIgniter\Model;

class DictionaryAlphabetOrdersModel extends Model
{
    protected $table      = 'dictionary_alphabet_orders';
    protected $primaryKey = 'alphabet_order_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //dictionary_abbrivation_Id	word_name	word_abbrivation	dictionary_id	have_POS_id 	flag
    protected $allowedFields = ['language_id', 'letter', 'order_no', 'flag'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'language_id' => 'required|is_natural|is_not_unique[language.language_id]',
        'letter' => 'required|char|min_length[1]|max_length[1]',
        'order_no' => 'is_natural',
    ];
    protected $validationMessages = [
        'language_id' => [
            'required' => 'select language from.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'letter' => [
            'required' => 'Please write short name of dictionary.',
            'char' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'order_no' => [
            'is_natural' => 'Not valid type',
        ]
    ];

    protected $skipValidation     = false;

    public function getdictionaryalphabetorder($where = ['flag >= ' => 1], $select = ['letter', 'order_no'])
    {
        $alphabetorder = $this->select($select)->Where($where)->findAll();
        return array_column($alphabetorder, 'letter', 'order_no');
    }
    public function get_dictionaryalphabetorder_byId($where = ['flag >= ' => 10], $select = "*")
    {
        $alphabetorder = $this->select($select)->Where($where)->findAll(); 
        return $alphabetorder;
    }
    public function get_dictionaryalphabetorder_groupdropdown($where = ['flag >= ' => 5], $select = ['letter', 'order_no'])
    {
        $alphabetorder = array();
        $alphabetorder[0]  = 'Please select';
        $language_ids = $this->select('lan.language_id, language_name')->distinct()
            ->join('language as lan', 'dictionary_alphabet_orders.language_id = lan.language_id')
            ->Where('dictionary_alphabet_orders.language_id = lan.language_id')
            ->get()->getResult('array');

        foreach ($language_ids as $lang) { 
            $where['language_id'] = $lang['language_id'];
            //$letter_order= array_column($this->get_dictionaryalphabetorder_byId($where, $select), 'letter', 'order_no');
            $alphabetorder[$lang['language_name']] = array_column($this->get_dictionaryalphabetorder_byId($where, $select), 'letter', 'letter');
        }
       // var_dump($alphabetorder); 
        return $alphabetorder;
    }
}
