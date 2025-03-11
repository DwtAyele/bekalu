<?php

namespace App\Models;

use CodeIgniter\Model;

class DictionaryModel extends Model
{
    protected $table      = 'dictionary';
    protected $primaryKey = 'dictionary_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //dictionary_id	full_name	short_name	dictionary_language_from	dictionary_language_to	dictionary_type	published_date	author	flag
    protected $allowedFields = ['full_name', 'short_name', 'dictionary_language_from', 'dictionary_language_to', 'dictionary_type', 'published_date', 'author', 'flag'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'full_name' => 'required|string|min_length[2]|max_length[100]',
        'short_name' => 'required|string|min_length[2]|max_length[25]',
        'dictionary_language_from' => 'required|is_natural|is_not_unique[language.language_id]',
        'dictionary_language_to' => 'required|is_natural|is_not_unique[language.language_id]',
        'dictionary_type' => 'permit_empty|string|min_length[2]|max_length[200]',
        'published_date' => 'valid_date[m/y]',
        'author' => 'permit_empty|string|min_length[2]|max_length[60]',
    ];
    protected $validationMessages = [
        'full_name' => [
            'required' => 'Please write the dictionary name.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'short_name' => [
            'required' => 'Please write short name of dictionary.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'dictionary_language_from' => [
            'required' => 'select language from.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'dictionary_language_to' => [
            'required' => 'select language to',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'dictionary_type' => [
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'published_date' => [
            'valid_date' => 'Please enter valid date.',
        ],
        'author' => [
            'string' => 'Not valid author',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ]
    ];

    protected $skipValidation = false;

    public function getdictionarys($where = ['flag <= ' => 1], $select = ['dictionary_id', 'short_name'])
    {
        $dictionary = $this->select($select)->Where($where)->findAll();
        return array_column($dictionary, 'short_name', 'dictionary_id');
    }

    public function get_dictionary_byId($where = ['flag = ' => 1], $select = ['dictionary_id', 'short_name'])
    {
        $dictionary = $this->select($select)->Where($where)->findAll();
        return $dictionary;
    }

    public function get_dictionary_data(
        $select = 'd.short_name, d.flag, d.dictionary_id, COUNT(DISTINCT(wm.word_meaning_id)) AS ትርጉሞች, COUNT(DISTINCT(wm.page_no)) AS ገጽ',
        $match = ['d.flag <=' => 10],
        $groupBy = ['d.dictionary_id'],
        $orderdby = 'd.short_name',
        $order = 'ASC' //'ASC','DESC','RANDOM'
    ) {
        $result = $this->select('ROW_NUMBER() over(ORDER BY ' . $orderdby . ') AS row_num, ' . $select)
            ->from('dictionary as d')
            ->join('word_meaning AS wm', 'd.dictionary_id = wm.dictionary_id')
            ->join('words  AS w', 'wm.word_id = w.word_id')
            ->join('meanings AS m', 'wm.meaning_id = m.meaning_id')

            ->where($match)
            ->groupBy($groupBy)
            ->orderBy($orderdby, $order);
        //var_dump();
        return $this;
    }
}
