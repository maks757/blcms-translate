<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 16.02.2016
 * Time: 16:47
 */

namespace bl\cms\translate\models\form;

use bl\cms\translate\models\entities\Message;
use yii\base\Model;
use yii\db\IntegrityException;

class EditMessageForm extends Model
{
    public $id;
    public $language;
    public $translation;

    public function rules()
    {
        return [
            ['id', 'required'],
            ['language', 'required'],
            ['translation', 'required'],
        ];
    }

    public function edit() {
        try {
            $data = Message::find()->where(['id' => $this->id, 'language' => $this->language])->one();
            if(!empty($data))
            {
                $data['translation'] = $this->translation;
                $data->update();
            }
            return true;
        }
        catch(IntegrityException $ex){
        }
    }
}