<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 16.02.2016
 * Time: 16:47
 */

namespace bl\cms\translate\models\form;

use bl\cms\translate\models\entities\Message;
use bl\cms\translate\models\entities\SourceMessage;
use bl\multilang\entities\Language;
use yii\base\Model;

class EditSourceMessageForm extends Model
{
    public $id;
    public $base_category;
    public $base_language;
    public $category;
    public $translation;
    public $language;
    public $message;

    public function rules()
    {
        return [
            ['id', 'required'],
            ['message', 'required'],
            ['category', 'required'],
            ['language', 'required'],
            ['translation', 'string', 'min' => 0],
            ['base_category', 'string', 'min' => 0],
            ['base_language', 'string', 'min' => 0],
        ];
    }

    public function edit() {
        if($this->validate()) {
            $dataSourceMessageQuarry = SourceMessage::find()->where(['id' => $this->id]);
            $dataMessage = new Message();

            if(!empty($this->base_category))
                $dataSourceMessageQuarry->andWhere(['category' => $this->base_category]);
            if(!empty($this->base_language))
                $dataSourceMessageQuarry->with(['messages' => function($query) {
                    $query->andWhere(['language' => $this->base_language]);
                }]);

            $sourceMessageQuarry = $dataSourceMessageQuarry->one();

            if(!empty($sourceMessageQuarry)) {
                $sourceMessageQuarry['category'] = $this->category;
                $sourceMessageQuarry['message'] = $this->message;
                $dataMessage->id = $sourceMessageQuarry['id'];
                $dataMessage->language = $this->language;
                $dataMessage->translation = $this->translation;
                if(strcasecmp($this->base_language, Language::findOne(1)['lang_id']) == 0) {
                    $sourceMessageQuarry->update();
                } else {
                    $sourceMessageQuarry->update();
                    $dataMessage->save();
                }
            }
            return true;
        }
    }
}