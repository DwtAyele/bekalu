<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSuggestionsModel extends Model
{
    protected $table      = 'user_suggestions';
    protected $primaryKey = 'user_suggestion_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //user_suggestion_id	suggestion	word_meaning_id	user_id	comment	flag	
    protected $allowedFields = ['suggestion', 'word_meaning_id', 'user_id', 'comment', 'flag'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'suggestion' => 'required|string|min_length[2]|max_length[20]',
        'word_meaning_id' => 'required|is_natural|is_not_unique[word_meaning.word_meaning_id]',
        'user_id' => 'required', //|is_not_unique[user.user_id]
        'comment' => 'permit_empty|string',
    ];
    protected $validationMessages = [
        'suggestion' => [
            'required' => 'Please write the dictionary name.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'word_meaning_id' => [
            'required' => 'select language from.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'user_id' => [
            'required' => 'select language to',
            // 'is_not_unique' => 'Not valid id',
        ],
        'comment' => [
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
    ];

    protected $skipValidation     = false;

    public function getsuggestions($word_meaning_id)
    {
        // $wordmeaningModel = new WordMeaningModel();
        $this->SELECT("word_meaning_id, user_id, comment, created_at, flag")
            ->selectSum('suggestion = 1 as LIKES')
            ->selectSum('suggestion = 2 as DISLIKES')
            ->selectSum('suggestion = 3 as FLAGE')
            //->whereIn('word_meaning_id = ', $word_meaning_id('word_meaning_id'))
            ->groupBy('word_meaning_id')
            ->selectSubquery($word_meaning_id, 'word_meaning_id');
        return $this;
    }
}
