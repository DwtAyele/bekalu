<?php

namespace App\Models;

use CodeIgniter\Model;

class MeaningsModel extends Model
{
    protected $table      = 'meanings';
    protected $primaryKey = 'meaning_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    //meaning_id	meaning	example	homonyms	part_of_speech_id	language_id	meaning_image	created_at	updated_at	flag	
    protected $allowedFields = ['meaning', 'example', 'homonyms', 'part_of_speech_id', 'language_id', 'meaning_image', 'alphabet_order', 'created_at', 'updated_at', 'flag'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'meaning' => 'required',
        'example' => 'permit_empty|string',
        'homonyms' => 'permit_empty|string|max_length[15]', //min_length[1]|
        'part_of_speech_id' => 'permit_empty|is_natural', //|is_not_unique[parts_of_speechs.part_of_speech_id]',//parts_of_speechs
        'language_id' => 'required|is_natural|is_not_unique[language.language_id]',
        // 'meaning_image' => 'uploaded[meaning_image]|is_image[meaning_image]',//permit_empty|
    ];
    protected $validationMessages = [
        'meaning' => [
            'required' => 'Please write the meaning.',
            //'is_unique' => 'Already exist',
        ],
        'example' => [
            'string' => 'Not valid type',
        ],
        'homonyms' => [
            'string' => 'Not valid data.',
            //'min_length' => 'To Short.',
            'max_length' => 'To long.',
        ],
        'part_of_speech_id' => [
            'is_natural' => 'Not valid data',
            //'is_not_unique' => 'Not valid id',
        ],
        'language_id' => [
            'required' => 'Not valid language id',
            'is_natural' => 'Not valid type',
            'is_not_unique' => 'Not valid id',
        ],
        'meaning_image' => [
            'uploaded' => "Please upload file, Not a valid type.",
            'is_image' => "Uploaded file is not an image.",
        ]
    ];

    protected $skipValidation     = false;

    public function set_insert_meanings($in_Data, $flag = 5)
    {
        //meaning	example	homonyms
        $data = array_intersect_key($in_Data, array_flip($this->allowedFields));
        $data['language_id'] = intVal($in_Data['languageto']);
        $data['flag'] = $flag;
        $where = ['meaning' => $data['meaning'], 'example' => $data['example']];

        $meaning_id = $this->where($where)->select('meaning_id')->first();

        if (is_numeric(intVal($meaning_id)) && !is_null($meaning_id)) {
            $this->update($meaning_id, $data);
        }
        if (is_null($meaning_id)) {
            $meaning_id = $this->set($data)->insert();
            return $meaning_id;
        }
        return $meaning_id['meaning_id'];
    }

    public function meaning_update($m_id, $up_data)
    {
        $data = array_intersect_key($up_data, array_flip($this->allowedFields));
        return $this->update($m_id, $data);
    }
    public function deleteMeaning($id = ['m_id' => null, 'wm_id' => null])
    {
        $WordMeaningModel = new WordMeaningModel();
        $query = $WordMeaningModel->select('*')
            ->Where(['word_meaning_id' => $id['m_id']])
            ->countAllResults();
        /* var_dump("m_id = " . $id['m_id']);
        var_dump("</br>");
        var_dump("wm_id = " . $id['wm_id']);
        var_dump("</br>");
        var_dump("Query => " . $query);*/
        if ($query > 1)
            $WordMeaningModel->deleteWordMeaning($id['wm_id']);
        elseif ($query == 1)
            $this->delete($id['m_id']);
    }
}
