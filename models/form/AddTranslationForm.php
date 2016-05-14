<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 15.02.2016
 * Time: 22:40
 */

namespace bl\cms\translate\models\form;


use bl\cms\translate\models\entities\SourceMessage;
use Yii;
use yii\base\Model;
use yii\db\IntegrityException;

class AddTranslationForm extends Model
{
    public $CategoryText;
    public $TranslationText;

    public function rules()
    {
        return [
            ['CategoryText', 'required'],
            ['TranslationText', 'required'],
        ];
    }

    public function add() {
        try {
            $countMessageQuarry = SourceMessage::find()
                ->where(['category' => $this->CategoryText, 'message' => $this->TranslationText]);
            if($countMessageQuarry->count() < 1) {
                $source_messag = new SourceMessage();
                $source_messag->category = $this->CategoryText;
                $source_messag->message = $this->TranslationText;
                $source_messag->save();
            }
            return true;
        }
        catch(IntegrityException $ex){

        }
    }
}