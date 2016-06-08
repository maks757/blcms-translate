<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 15.02.2016
 * Time: 23:14
 */

namespace bl\cms\translate\models\entities;

use yii\db\ActiveRecord;
/**
 * message model
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 */
class Message extends ActiveRecord
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['language', 'translation'], 'string'],
            [['language', 'translation'], 'required']
        ];
    }

    public static function tableName() { return 'message'; }

    public function getSource() {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }
}