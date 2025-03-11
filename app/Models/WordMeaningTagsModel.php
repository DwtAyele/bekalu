<?php

namespace App\Models;

use CodeIgniter\Model;

class WordMeaningTagsModel extends Model
{
    protected $table      = 'word_meaning_tags';
    protected $primaryKey = 'word_meaning_tag_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //word_meaning_tag_id	tag_id	word_meaning_id	flag
    protected $allowedFields = ['tag_id', 'word_meaning_id', 'flag'];

    // protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'tag_id' => 'required|is_natural|is_not_unique[tags.tag_id]',
        'word_meaning_id' => 'required|is_natural|is_not_unique[word_meaning.word_meaning_id]',
    ];
    protected $validationMessages = [
        'tag_id' => [
            'required' => 'select a tag id.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'word_meaning_id' => [
            'required' => 'select a word meaning.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ]
    ];

    protected $skipValidation     = false;

    public function getwordtags($where = ['wmt.word_meaning_id' => 0], $groupby = 'wmt.word_meaning_tag_id')
    {
        $result = $this->select(['t.tag_id', 'tag'])
            ->from('word_meaning_tags AS wmt')
            ->join('tags AS t', 'wmt.tag_id = t.tag_id')
            ->where($where)
            ->groupby($groupby);

        $tags = $result->get()->getResultArray();
        return array_column($tags, 'tag_id', 'tag');
    }
    public function insert_word_meaning_tags($in_Data, $flag = 5)
    {
        if (is_null($in_Data['tags'])) {
            return $in_Data['tags'];
        }
        $i = 0;
        $word_meaning_tag = [];

        foreach ($in_Data['tag_id'] as $tag) {

            $in_ = ['tag_id' => $tag, 'word_meaning_id' => $in_Data['word_meaning_id']];

            $word_meaning_tag_id = $this->select('*')->where($in_)->first();

            if ($word_meaning_tag_id  == null) {
                $in_['flag'] = $flag;
                $word_meaning_tag[$i++] = $this->insert($in_);
            }
        }
        return $word_meaning_tag;
    }
}
