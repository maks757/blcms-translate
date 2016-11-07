<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 15.02.2016
 * Time: 23:13
 */

namespace maks757\translate\models\entities;

use yii\db\ActiveRecord;
/**
 * source_message model
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 */
class SourceMessage extends ActiveRecord
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category', 'message'], 'string']
        ];
    }

    public static function tableName() {
        return 'source_message';
    }

    public function getMessages() {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }
}