<?php

namespace App\Models;

use CodeIgniter\Model;

class WordPartofSpeechModel extends Model
{
    protected $table      = 'word_part_of_speech';
    protected $primaryKey = 'word_part_of_speech_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //word_part_of_speech_id	word_id	part_of_speech_id	new_word_id	flag	
    protected $allowedFields = ['word_id', 'part_of_speech_id', 'new_word_id', 'flag'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'word_id' => 'required|is_natural|is_not_unique[words.word_id]',
        'part_of_speech_id' => 'required|is_natural|is_not_unique[parts_of_speechs.part_of_speech_id]',
        'new_word_id' => 'required|is_natural|is_not_unique[words.word_id]',
    ];
    protected $validationMessages = [
        'word_id' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'part_of_speech_id' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'new_word_id' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ]
    ];

    protected $skipValidation     = false;
}
