<?php

/* @var $allCategories SourceMessage[] */
/* @var $selectedCategory SourceMessage */
/* @var $allLanguages Language[] */
/* @var $selectedLanguage Language */
/* @var $sourceMessages SourceMessage[] */
/* @var $pages yii\data\Pagination[] */
/* @var $addTranslationFormModel AddTranslationForm */

use bl\cms\translate\Translation;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Перевод';
$dataGet = Yii::$app->request->get();
?>

<div class="row">

    <!--Filter Translation-->
    <div class="col-md-12">
        <? ActiveForm::begin([ 'action' => Url::to(['index']), 'method' => 'get'])?>
        <div class="form-group col-md-5">
            <select id="filtertranslationform-categoryid" class="form-control" name="categoryId">
                <option value="">--<?= Translation::t('main', 'all') ?>--</option>
                <? foreach ($allCategories as $category):?>
                    <option <?= $selectedCategory == $category['id'] ? 'selected' : '' ?> value="<?= $category['id'] ?>">
                        <?= $category['category'] ?>
                    </option>
                <? endforeach;?>
            </select>
        </div>
        <div class="form-group col-md-5">
            <select id="filtertranslationform-languageid" class="form-control" name="languageId">
                <? foreach ($allLanguages as $language):?>
                    <option <?= $selectedLanguage == $language->id ? 'selected' : '' ?> value="<?= $language->id ?>">
                        <?= $language->name ?>
                    </option>
                <? endforeach;?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-primary pull-left" value="Отфильтровать">
        </div>
        <? ActiveForm::end(); ?>
    </div>

    <!-- Translation -->
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <i class="fa fa-file-text"></i>
                    <?= Translation::t('main', 'List translation') ?>
                </h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <? if(!empty($sourceMessages)): ?>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th><?= Translation::t('main', 'Category') ?></th>
                                <th><?= Translation::t('main', 'source') ?></th>
                                <? if(!empty($sourceMessages[0]->messages)): ?>
                                    <th><?= Translation::t('main', 'Translation') ?></th>
                                    <th><?= Translation::t('main', 'Language') ?></th>
                                <? endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <? foreach($sourceMessages as $sourceMessage): ?>
                                <tr>
                                    <td><?= $sourceMessage->category ?></td>
                                    <td><?= $sourceMessage->message ?></td>
                                    <? if(!empty($sourceMessage->messages)): ?>
                                        <td><?=$sourceMessage->messages[0]->translation?></td>
                                    <? else: ?>
                                        <td></td>
                                    <? endif; ?>
                                    <td class="text-right">
                                        <a href="<?= Url::toRoute([
                                            'message/edit',
                                            'categoryId' => $sourceMessage->id,
                                            'languageId' => $selectedLanguage
                                        ]) ?>" class="btn btn-warning btn-circle glyphicon glyphicon-edit" type="button">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?= Url::toRoute([
                                            'message/delete',
                                            'categoryId' => $sourceMessage->id,
                                            'languageId' => $selectedLanguage
                                        ]) ?>" class="btn btn-danger btn-circle glyphicon glyphicon-remove" type="button">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </td>

                                </tr>
                            <? endforeach; ?>
                            </tbody>
                        </table>
                    <? endif; ?>
                </div>
            </div>
            <div class="ibox-footer">
                <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#addTranslationFormModel">
                    <i class="fa fa-user-plus"></i> <?= Translation::t('main', 'Add') ?>
                </a>
                <div class="text-center">
                    <?= LinkPager::widget(['pagination' => $pages]) ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<!-- Add Translation Modal Dialog -->
<div class="modal fade" id="addTranslationFormModel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <? $addForm = ActiveForm::begin(['action' => Url::toRoute(['message/add']), 'method'=>'post']) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Добавить новый перевод</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= $addForm->field($addModel, 'category', [
                        'inputOptions' => [
                            'placeholder' => 'Текст',
                            'class' => 'form-control'
                        ]
                    ])->label('Категория')
                    ?>
                </div>
                <div class="form-group">
                    <?= $addForm->field($addModel, 'message', [
                        'inputOptions' => [
                            'placeholder' => "Текст",
                            'class' => 'form-control'
                        ]
                    ])->label('Перевод')
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary pull-right" value="Добавить">
            </div>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>
