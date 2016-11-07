<?php

/* @var $allCategories SourceMessage[] */
/* @var $selectedCategory SourceMessage */
/* @var $allLanguages Language[] */
/* @var $selectedLanguage->id Language */
/* @var $sourceMessages SourceMessage[] */
/* @var $pages yii\data\Pagination[] */
/* @var $addTranslationFormModel AddTranslationForm */

use maks757\translate\Translation;
use maks757\multilang\widgets\languageList\LanguageListWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Перевод';
$dataGet = Yii::$app->request->get();
?>
<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-title">
                <h3><?= Translation::t('main', 'Add new category') ?></h3>
            </div>
            <div class="panel-body">
                <?php $addForm = ActiveForm::begin(['action' => Url::toRoute(['message/add']), 'method'=>'post']) ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Translation::t('main', 'Select category') ?></label>
                            <select id="filtertranslationform-categoryid" class="form-control" name="categoryId">
                                <option value="">--<?= Translation::t('main', 'select') ?>--</option>
                                <?php foreach ($allCategories as $category):?>
                                    <option <?= $selectedCategory == $category['id'] ? 'selected' : '' ?> value="<?= $category['id'] ?>">
                                        <?= $category['category'] ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Translation::t('main', 'or write new') ?></label>
                            <?= $addForm->field($addModel, 'category', [
                                'inputOptions' => [
                                    'placeholder' => Translation::t('main', 'text'),
                                    'class' => 'form-control'
                                ]
                            ])->label(false)
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?= $addForm->field($addModel, 'message', [
                        'inputOptions' => [
                            'placeholder' => Translation::t('main', 'text'),
                            'class' => 'form-control'
                        ]
                    ])->label(Translation::t('main', 'Translation'))
                    ?>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" style="width: 100%;" value="<?= Translation::t('main', 'Add')?>">
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <!--Filter Translation-->
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-title">
                <h3><?= Translation::t('main', 'Filter') ?></h3>
            </div>
            <div class="panel-body">
                <?php ActiveForm::begin([ 'action' => Url::to(['index']), 'method' => 'get'])?>
                <div class="form-group">
                    <label><?= Translation::t('main', 'Category') ?></label>
                    <select id="filtertranslationform-categoryid" class="form-control" name="categoryId">
                        <option value="">--<?= Translation::t('main', 'all') ?>--</option>
                        <?php foreach ($allCategories as $category):?>
                            <option <?= $selectedCategory == $category['id'] ? 'selected' : '' ?> value="<?= $category['id'] ?>">
                                <?= $category['category'] ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= Translation::t('main', 'Language') ?></label>
                    <select id="filtertranslationform-languageid" class="form-control" name="languageId">
                        <?php foreach ($allLanguages as $language):?>
                            <option <?= $selectedLanguage->id == $language->id ? 'selected' : '' ?> value="<?= $language->id ?>">
                                <?= $language->name ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div>
                    <input style="width: 100%;" type="submit" class="btn btn-primary" value="<?= Translation::t('main', 'Filter the') ?>">
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Translation -->
    <div class="col-md-12">
        <div class="panel float-e-margins">
            <div class="panel-title">
                <h5>
                    <i class="fa fa-file-text"></i>
                    <?= Translation::t('main', 'List translation') ?>
                </h5>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php if(!empty($sourceMessages)): ?>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-sm-2"><?= Translation::t('main', 'Category') ?></th>
                                <th class="col-sm-4"><?= Translation::t('main', 'source') ?></th>
                                <?php if(!empty($sourceMessages[0]->messages)): ?>
                                    <th class="col-sm-4"><?= Translation::t('main', 'Translation') ?></th>
                                <?php else: ?>
                                    <th class="col-sm-4"></th>
                                <?php endif; ?>
                                <th><?= Translation::t('main', 'Languages') ?></th>
                                <th class="col-sm-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($sourceMessages as $sourceMessage): ?>
                                <?php $messageTranslation = ArrayHelper::index($sourceMessage->messages, 'language')[$selectedLanguage->lang_id]->translation ?>
                                <tr style="<?= ((empty($messageTranslation) && !empty(ArrayHelper::index($languages, 'id')[$selectedLanguage->id])) ? 'color: #ed5565; border-left: 10px solid #ed5565;' : 'color: green; border-left: 10px solid green;') ?>">
                                    <td><?= $sourceMessage->category ?></td>
                                    <td><?= $sourceMessage->message ?></td>
                                    <?php if(!empty($sourceMessage->messages)): ?>
                                        <td><?= $messageTranslation ?></td>
                                    <?php else: ?>
                                        <td></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php
                                        $translations = ArrayHelper::index($sourceMessage->messages, 'language');
                                        foreach($languages as $language){
                                            echo Html::a(
                                                $language->name,
                                                Url::toRoute([
                                                    'message/edit',
                                                    'categoryId' => $sourceMessage->id,
                                                    'languageId' => $language->id
                                                ]),
                                                [
                                                    'class' => (!empty($translations[$language->lang_id]) ?
                                                            'label label-primary' :
                                                            'label label-danger'
                                                        ) . ' col-sm-12',
                                                    'title' => (!empty($translations[$language->lang_id]) ?
                                                        Translation::t('main', 'Change translation') :
                                                        Translation::t('main', 'Add translation')
                                                    ),
                                                ]
                                            );
                                            echo '<br>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <a href="<?= Url::toRoute([
                                            'message/edit',
                                            'categoryId' => $sourceMessage->id,
                                            'languageId' => $selectedLanguage->id
                                        ]) ?>" class="btn glyphicon glyphicon-<?= (empty($messageTranslation) ? 'plus btn-primary' : 'pencil btn-info')?>" type="button">
                                        </a>
                                        <a href="<?= Url::toRoute([
                                            'message/delete',
                                            'categoryId' => $sourceMessage->id,
                                            'languageId' => $selectedLanguage->id
                                        ]) ?>" class="btn btn-danger glyphicon glyphicon-trash" type="button">
                                        </a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-center">
                    <?= LinkPager::widget(['pagination' => $pages]) ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
