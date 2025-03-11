<?php

namespace App\Models;

use CodeIgniter\Model;

class WordsModel extends Model
{
    protected $table      = 'words';
    protected $primaryKey = 'word_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    //word_id	word	pronunciation	accessibility	Language_id	created_at	updated_at	short_note	flag	
    protected $allowedFields = ['word', 'pronunciation', 'accessibility', 'Language_id', 'created_at', 'updated_at', 'short_note', 'flag'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'word' => 'required|string|min_length[1]|max_length[60]|is_unique[words.word]',
        //Checks if this field value exists in the database. Optionally set a column and value
        //value to ignore, useful when updating records to ignore itself.
        //is_unique[table.field,ignore_field,ignore_value]
        'pronunciation' => 'permit_empty|string|max_length[60]', //min_length[1]|
        'accessibility' => 'permit_empty|string|max_length[60]', //min_length[1]|
        //Checks the database to see if the given value exist. 
        //Can ignore records by field/value to filter (currently accept only one filter).
        //is_not_unique[table.field,where_field,where_value]
        'Language_id' => 'required|is_natural|is_not_unique[language.language_id]',
        'short_note' => 'permit_empty|string|max_length[30]', //|min_length[1]
    ];
    protected $validationMessages = [
        'word' => [
            'required' => 'Please write the word.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
            'is_unique' => 'Already exist',
        ],
        'pronunciation' => [
            'string' => 'Not valid type',
            //'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'accessibility' => [
            'string' => 'Not valid type',
            //'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'Language_id' => [
            'required' => 'Not valid language id',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'short_note' => [
            'string' => 'Not valid type',
            //'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ]
    ];

    protected $skipValidation     = false;
    //word_id	word	pronunciation	accessibility	Language_id	created_at	updated_at	short_note	flag

    public function getword($where = ['words.word_id' => null])
    {

        $result = $this->select('ROW_NUMBER() over ( order by words.word_id,d.short_name ASC) AS row_num, words.*,words.Language_id AS languagefrom_id, 
            m.*,m.language_id AS languageto_id, m.flag AS mflag, ps.abbreviation, 
            wm.word_meaning_id, wm.user_id, wm.dictionary_id, wm.page_no, wm.comment, wm.num_like, wm.num_dislike, wm.user_report, d.short_name')
            ->join('word_meaning as wm', 'words.word_id = wm.word_id')
            ->join('meanings AS m', 'wm.meaning_id = m.meaning_id')
            ->join('dictionary AS d', 'wm.dictionary_id = d.dictionary_id')
            ->join('parts_of_speechs AS ps', 'm.part_of_speech_id = ps.part_of_speech_id', 'LEFT')
            ->where($where)
            ->orderBy('d.short_name, words.word_id');

        return $result->get()->getResultArray();
    }

    public function set_insert_word($in_Data, $flag = 5)
    {
        //isset($in_Data['languagefrom']) ? $data['Language_id'] = $in_Data['languagefrom'] : '';
        $col = ['word' => null, 'pronunciation' => null, 'accessibility' => null, 'short_note' => null];
        $data = array_intersect_key($in_Data, $col);
        $data['Language_id'] = $in_Data['languagefrom'];
        $data['flag'] = $flag;

        $word_id = $this->select('word_id')->where($data)->first();

        if (is_null($word_id)) {
            $word_id = $this->insert($data);
            if (is_bool($word_id)) {
                $word = array_shift($data); //to remove 'word'

                $this->set($data)->where('word', $word)->update();
                $word_id = $this->select('word_id')->where('word', $word)->first();
                return $word_id['word_id'];
            }
            return intVal($word_id);
        }
        return $word_id['word_id'];
    }
    public function word_update($wm_id, $up_data)
    {
        $data = array_intersect_key($up_data, array_flip($this->allowedFields));
        return $this->update($wm_id, $data);
    }
    
}
