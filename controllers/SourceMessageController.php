<?php
/*
 * @author Maxim 
*/


namespace bl\cms\translate\controllers;


use bl\cms\translate\models\entities\SourceMessage;
use bl\cms\translate\models\form\AddTranslationForm;
use bl\cms\translate\models\form\EditSourceMessageForm;
use bl\multilang\entities\Language;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class SourceMessageController extends Controller
{
    public function actionAdd() {
        $addTranslationFormModel = new AddTranslationForm();
        if($addTranslationFormModel->load(Yii::$app->request->post()) && $addTranslationFormModel->add())
            return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionEdit(){
        $model = new EditSourceMessageForm();
        if($data = Yii::$app->request->get())
        {
            $model->id = $data[id];
            $query = SourceMessage::find()->where(['id' => $data[id]]);
            if(!empty($data[category])) {
                $query->andWhere(['category' => $data[category]]);
            }
            if(!empty($data[lang])) {
                $query->with(['messages' => function($query) {
                    $query->andWhere(['language' => Yii::$app->request->get('lang')]);
                }]);
            }

            $query = $query->asArray()->one();

            $model->category = $query[category];
            $model->message = $query[message];
            $model->language = $data[lang];
            $model->translation = $query[translation];
            $model->base_category = $data[category];
            $model->base_language = $data[lang];
            Url::remember(Yii::$app->request->referrer);

            return $this->render('edit',[
                'model' => $model,
                'allLanguages' => Language::find()->all(),
                'allCategories' => SourceMessage::find()->select(['category'])->groupBy('category')->asArray()->all(),
                'selectedCategory' => $data[category],
                'selectedLanguage' => $data[lang],
            ]);
        }

        if($data = Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->edit()) {
                return $this->redirect(Url::previous());
            }
        }
    }

    public function actionDelete($id)
    {
        if(!empty($id)){
            SourceMessage::deleteAll(['id' => $id]);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
}