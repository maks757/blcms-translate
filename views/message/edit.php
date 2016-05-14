<?php

use bl\cms\translate\models\form\EditMessageForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model EditMessageForm */

$this->title = 'Изменение';
?>

<div class="row">

    <!--Edit data-->
    <div class="col-md-12">
        <? ActiveForm::begin([ 'action' => Url::to(['edit']), 'method' => 'post'])?>
        <div class="form-group col-md-5">
            <?= Html::activeHiddenInput($model, 'id')?>
            <?= Html::activeHiddenInput($model, 'language')?>
            <?= Html::label("Language " . $lang, ['class' => 'form-control'])?>
        </div>
        <div class="form-group col-md-5">
            <?= Html::activeTextInput($model, 'translation', ['class' => 'form-control']) ?>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-primary pull-left" value="Изменить">
        </div>
        <? ActiveForm::end(); ?>
    </div>

</div>
