<?php

use maks757\translate\models\form\EditMessageForm;
use maks757\translate\Translation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model EditMessageForm */

$this->title = 'Изменение';
?>

<div class="row">

    <!--Edit data-->
    <div class="col-md-12">
        <?php ActiveForm::begin([ 'action' => Url::to(['edit']), 'method' => 'post'])?>
        <div class="form-group col-md-5">
            <?= Html::activeHiddenInput($model, 'id')?>
            <?= Html::label(Translation::t('message', 'Language') . ' '. $language->name, ['class' => 'form-control'])?>
        </div>
        <div class="form-group col-md-5">
            <?= Html::label(Translation::t('message', 'Text') . ' '. $language->name, ['class' => 'form-control'])?>
            <?= Html::activeTextInput($model, 'message', ['class' => 'form-control']) ?>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-primary pull-left" value="<?= Translation::t('message', 'Update') ?>">
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
