<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 15.02.2016
 * Time: 19:00
 */

namespace bl\cms\translate\controllers;

use backend\models\form\translate;
use bl\cms\translate\models\entities\SourceMessage;
use bl\cms\translate\models\form\AddTranslationForm;
use bl\multilang\entities\Language;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;

class TranslationController extends Controller
{

    public function actionIndex()
    {
        $langId = Yii::$app->request->get('langId');
        $category = Yii::$app->request->get('category');

        $query = SourceMessage::find();
        if(!empty($langId) && $langId != Yii::$app->sourceLanguage) {
            $query->with(['messages' => function($query) {
                $query->andWhere(['language' => Yii::$app->request->get('langId')]);
            }]);
        }
        else {
            $langId = Language::findOrDefault(null)->lang_id;
            $query->with(['messages' => function($query) {
                $query->andWhere(['id' => false]);
            }]);
        }
        if(!empty($category)) {
            $query->where(['category' => $category]);
        }

        $query->orderBy(["id" => SORT_DESC]);
        $messages_count = clone $query;
        $pages = new Pagination(['totalCount' => $messages_count->count(), 'defaultPageSize' => 50,]);
        $messages = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'allLanguages' => Language::find()->all(),
            'allCategories' => SourceMessage::find()->select(['category'])->groupBy('category')->asArray()->all(),
            'sourceMessages' => $messages,
            'pages' => $pages,
            'addTranslationFormModel' => new AddTranslationForm(),
            'selectedCategory' => $category,
            'selectedLanguage' => $langId
        ]);
    }
}