<?php
namespace bl\cms\translate\controllers;

use bl\cms\translate\models\entities\Message;
use bl\cms\translate\models\form\EditMessageForm;
use bl\multilang\entities\Language;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class MessageController extends Controller
{
    public function actionEdit(){
        $model = new EditMessageForm();
        if($data = Yii::$app->request->get())
        {
            $model->id = $data[id];
            $model->language = $data[lang];
            $model->translation = Message::find()->where(['id' => $data[id], 'language' => $data[lang]])->one()[translation];
            Url::remember(Yii::$app->request->referrer);
            return $this->render('edit', array('model' => $model, 'lang' => Language::find()->where(array('lang_id' => $model->language))->one()->name));
        }
        if($data = Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->edit()) {
                return $this->redirect(Url::previous());
            }
        }
    }

    public function actionDelete($id, $lang)
    {
        if(!empty($id) && !empty($lang)){
            Message::find()->where(['id' => $id, 'language' => $lang])->one()->delete();
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
}