<?php
use bl\cms\translate\models\entities\SourceMessage;
use bl\cms\translate\models\form\EditSourceMessageForm;
use bl\multilang\entities\Language;
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
        <? ActiveForm::begin([ 'action' => Url::to(['edit']), 'method' => 'post'])?>
        <?= Html::activeHiddenInput($model, 'id')?>
        <?= Html::activeHiddenInput($model, 'base_category')?>
        <?= Html::activeHiddenInput($model, 'base_language')?>
        <div class="form-group col-md-5">
            <select id="filtertranslationform-categoryid" class="form-control" name="EditSourceMessageForm[category]">
                <? foreach ($allCategories as $category):?>
                    <option <?= $selectedCategory == $category[category] ? 'selected' : '' ?> value="<?= $category[category] ?>">
                        <?= $category[category] ?>
                    </option>
                <? endforeach;?>
            </select>
        </div>
        <div class="form-group col-md-5">
            <select id="filtertranslationform-languageid" class="form-control" name="EditSourceMessageForm[language]">
                <? foreach ($allLanguages as $language):?>
                    <option <?= $selectedLanguage == $language->lang_id ? 'selected' : '' ?> value="<?= $language->lang_id ?>">
                        <?= $language->name ?>
                    </option>
                <? endforeach;?>
            </select>
        </div>
        <div class="form-group col-md-5">
            <?= Html::activeTextInput($model, 'message', ['class' => 'form-control', 'placeholder' => "Текст"]) ?>
        </div>
        <div class="form-group col-md-5">
            <?= Html::activeTextInput($model, 'translation', ['class' => 'form-control', 'placeholder' => "Перевод"]) ?>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-primary pull-left" value="Изменить">
        </div>
        <? ActiveForm::end(); ?>
    </div>

</div>
