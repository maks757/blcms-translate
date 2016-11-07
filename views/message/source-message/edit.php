<?php
use maks757\translate\models\entities\SourceMessage;
use maks757\translate\models\form\EditSourceMessageForm;
use maks757\translate\Translation;
use maks757\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $allCategories SourceMessage[] */
/* @var $selectedCategory SourceMessage */
/* @var $allLanguages Language[] */
/* @var $selectedLanguage Language */
/* @var $model EditSourceMessageForm */
/* @var $language Language */

$this->title = 'Изменение';
?>

<div class="row">

    <!--Edit data-->
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([ 'action' => Url::to(['edit']), 'method' => 'post'])?>
            <?= Html::activeHiddenInput($source_message, 'id')?>
            <?= Html::activeHiddenInput($message, 'id')?>
            <div class="form-group col-md-6">
                <?= $form->field($source_message, 'category')->dropDownList(ArrayHelper::map($categories, 'category', 'category'), ['options' => [$source_message->id => ['Selected'=>'selected']]])->label(Translation::t('source_message', 'Category'))?>
            </div>
            <div class="form-group col-md-6">
                <?= $form->field($message, 'language')->dropDownList(ArrayHelper::map($languages, 'lang_id', 'name'), ['options' => [$language->lang_id => ['Selected'=>'selected']]])->label(Translation::t('source_message', 'Language'))?>
            </div>
            <div class="form-group col-md-6">
                <?= $form->field($source_message, 'message')->textInput(['placeholder' => "Текст"])->label(Translation::t('source_message', 'Text')) ?>
            </div>
            <div class="form-group col-md-6">
                <?= $form->field($message, 'translation')->textInput(['placeholder' => "Перевод"])->label(Translation::t('source_message', 'Translation')) ?>
            </div>
            <div class="col-md-2 pull-right">
                <input type="submit" class="btn btn-primary pull-right" value="<?= Translation::t('source_message', 'Update') ?>">
            </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
