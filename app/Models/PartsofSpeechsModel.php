<?php

namespace App\Models;

use CodeIgniter\Model;

class PartsofSpeechsModel extends Model
{
    protected $table      = 'parts_of_speechs';
    protected $primaryKey = 'part_of_speech_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //part_of_speech_id	part_of_speech	abbreviation	flag	
    protected $allowedFields = ['part_of_speech', 'abbreviation', 'flag'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'part_of_speech' => 'required|string|min_length[2]|max_length[25]',
        'abbreviation' => 'required|string|min_length[1]|max_length[10]',
    ];
    protected $validationMessages = [
        'part_of_speech' => [
            'required' => 'Please write the word.',
            'string' => 'Not valid data.',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'abbreviation' => [
            'required' => 'Not valid data',
            'string' => 'Not valid data.',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ]
    ];

    protected $skipValidation     = false;
    
    public function getpartsofspeechs($flag = 1)
    {
        $parts_of_speechs = $this->select(['part_of_speech_id', 'part_of_speech'])->orWhere(['flag = ' => $flag])->findAll();
        return array_column($parts_of_speechs, 'part_of_speech', 'part_of_speech_id');
    }
}
