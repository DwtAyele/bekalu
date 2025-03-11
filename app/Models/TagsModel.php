<?php

namespace App\Models;

use CodeIgniter\Model;

class TagsModel extends Model
{
    protected $table      = 'tags';
    protected $primaryKey = 'tag_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    //m	tag	abbreviation user_id	flag	
    protected $allowedFields = ['tag', 'abbreviation', 'user_id', 'flag'];

    // protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'tag' => 'required|is_unique[tags.tag]|string|min_length[2]|max_length[15]',
        'abbreviation' => 'permit_empty|string|min_length[2]|max_length[5]',
        'user_id' => 'required|is_natural|is_not_unique[users.user_id]',
    ];
    protected $validationMessages = [
        'tag' => [
            'required' => 'Please write the tag name.',
            'is_unique' => 'Already exist',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'abbreviation' => [
            //'required' => 'Please write the language abbreviation.',
            'string' => 'Not valid type',
            'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'user_id' => [
            'required' => 'select user from.',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ]
    ];

    protected $skipValidation     = false;

    public function gettags($usar_id = 0, $flag = 5)
    {
        $orwhere['flag <='] = $flag;
        if ($usar_id > 0) {
            $orwhere['user_id = '] = $usar_id;
        }
        $tags = $this->select(['tag_id', 'tag'])->orWhere($orwhere)->findAll();
        return array_column($tags, 'tag', 'tag_id');
    }

    public function insert_tag($in_Data) //alisa and valeriy
    {
        if (is_null($in_Data['tags'])) {
            return $in_Data['tags'];
        }
        $temp_tag_id =  array();
        $tags = $this->gettags($in_Data['user_id']);
        $i = 0;
        foreach (array_diff($in_Data['tags'], array_keys($tags)) as $newtag) {
            $insert = ['tag' => trim($newtag), 'user_id' => $in_Data['user_id']];
            $temp_tag_id[$i++] = $this->insert($insert);
        }
        $tag_id = array_merge($temp_tag_id, array_intersect(array_keys($tags), $in_Data['tags']));

        return $tag_id;
    }
}
