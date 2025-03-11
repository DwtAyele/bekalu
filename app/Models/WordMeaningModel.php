<?php

namespace App\Models;

use CodeIgniter\Model;

class WordMeaningModel extends Model
{
    protected $table      = 'word_meaning';
    protected $primaryKey = 'word_meaning_id';

    protected $useAutoIncrement = true;

    //protected $returnType     = 'array';
    protected $returnType    = \App\Entities\WordMeaning::class;
    protected $useSoftDeletes = false;
    //word_meaning_id	word_id	meaning_id	user_id	dictionary_id comment_page_no created_at num_like num_dislike	flag		
    protected $allowedFields = ['word_id', 'meaning_id', 'user_id', 'dictionary_id', 'page_no', 'comment', 'num_like', 'num_dislike', 'user_report', 'flag'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    // protected $deletedField  = 'deleted_at'; comment_page_no

    protected $validationRules    = [

        'word_id' => 'required|is_natural|is_not_unique[words.word_id]',
        'meaning_id' => 'required|is_natural|is_not_unique[meanings.meaning_id]',
        'user_id' => 'required|is_natural|is_not_unique[users.user_id]',
        'dictionary_id' => [
            'label' => 'Dictionary',
            'rules' => 'required|is_natural|is_not_unique[dictionary.dictionary_id]',
            'errors' => 'Not valid, Please select Dictionary',
        ],
        'page_no' => 'permit_empty|string',
        'comment' => 'permit_empty|string',
        'num_like' => 'permit_empty|is_natural',
        'num_dislike' => 'permit_empty|is_natural',
        'user_report' => 'permit_empty|is_natural',
    ];
    protected $validationMessages = [
        'word_id' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'meaning_id' => [
            'required' => 'Not valid data',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'user_id' => [
            'required' => 'Please write the word.',
            'is_natural' => 'Not valid data',
            'is_not_unique' => 'Not valid id',
        ],
        'dictionary_id' => [
            'required' => 'Not valid, Please select Dictionary',
            'is_natural' => 'Please select Dictionary, Not valid data',
            'is_not_unique' => 'Please select Dictionary from dropdown',
        ],
        'page_no' => [
            'string' => 'Not valid data',
        ],
        'comment' => [
            'string' => 'Not valid data',
        ],
        'num_like' => [
            'is_natural' => 'Not valid data',
        ],
        'num_dislike' => [
            'is_natural' => 'Not valid data',
        ],
        'user_report' => [
            'is_natural' => 'Not valid data',
        ]
    ];

    protected $skipValidation     = false;

    //word_meaning_id	word_id	meaning_id	user_id	dictionary_id comment_page_no	created_at	flag
    public function toinsert_word_meaning($in_Data, $flag = 5)
    {
        $this->reconnect();
        // $data = ['word_id' => $in_Data['word_id'], 'meaning_id' => $in_Data['meaning_id'], 'user_id' => $in_Data['user_id'], 'dictionary_id' => 1];
        $col = ['word_id' => '', 'meaning_id' => '', 'user_id' => '', 'dictionary_id' => ''];
        $data = array_intersect_key($in_Data, $col);
        //$where = array_intersect_key($in_Data, ['word_id' => '', 'meaning_id' => '']);
        $word_meaning_id = $this->select('word_meaning_id')->where($data)->first();

        $data['page_no'] = $in_Data['page_no'];
        $data['comment'] = $in_Data['comment'];
        $data['flag'] = $flag;
        if (is_null($word_meaning_id)) {
            $word_meaning_id = $this->insert($data);
            return $word_meaning_id;
        } else {
            $this->set($data)->where('word_meaning_id', $word_meaning_id->word_meaning_id)->update();
        }
        //return $meaning_id['word_meaning_id'];
        return intVal($word_meaning_id->word_meaning_id);
    }

    public function getgroupMeanig(
        $match = ['w.word' => ''],
        $groupBy = ['word_meaning.word_meaning_id'],
        $orderBy = 'w.word',
        $order = 'asc',
        $where = 'Like',
        $forlike = null,
        $limit = 100,
        $select = 'w.word_id, w.word, w.pronunciation, w.accessibility, w.short_note,
    m.meaning_id, m.meaning, m.example, m.homonyms, m.part_of_speech_id, m.meaning_image, m.alphabet_order, m.created_at, d.full_name, d.short_name,
    word_meaning.word_meaning_id, word_meaning.user_id, word_meaning.page_no, word_meaning.comment, num_like,
    num_dislike, user_report, dica.word_name, dica.word_abbrivation, ps.part_of_speech, ps.abbreviation'
    ) //'ASC','DESC','RANDOM'
    {
        $this->reconnect();
        $result = $this->select('ROW_NUMBER() over ( order by ' . $orderBy . ' ASC) AS row_num,' . $select)

            ->join('words as w', 'word_meaning.word_id = w.word_id')
            ->join('meanings AS m', 'word_meaning.meaning_id = m.meaning_id')
            ->join('dictionary AS d', 'word_meaning.dictionary_id = d.dictionary_id')
            ->join('users AS u', 'word_meaning.user_id = u.user_id')
            ->join('word_dic_abbrivation AS wda', 'w.word_id = wda.word_id', 'LEFT')
            ->join('dictionary_abbrivation AS dica', 'wda.dictionary_abbrivation_id = dica.dictionary_abbrivation_Id', 'LEFT')
            ->join('parts_of_speechs AS ps', 'm.part_of_speech_id = ps.part_of_speech_id', 'LEFT')

            ->$where($match)
            ->limit($limit)
            ->groupBy($groupBy)
            ->orderBy($orderBy, $order);

        if (!is_null($forlike)) {
            $this->like("w.word",  $forlike, "after"); //, before after both
        }
        // return $result->get()->getResult();
        return $this;
    }
    public function getwordmeaning_byid($where = ['flag = ' => 1], $select = ['word_id', 'meaning_id'])
    {
        $wordmeaning = $this->select($select)->Where($where)->findAll();
        return array_column($wordmeaning, 'word_id', 'meaning_id');
    }
    public function word_Meaning_update($wm_id, $up_data)
    {
        $data = array_intersect_key($up_data, array_flip($this->allowedFields));
        return $this->update($wm_id, $data);
    }
    public function deleteWordMeaning($id = null)
    {
        $this->delete($id);
    }
}
