<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>

<div class="right-sidebar">

    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">

        <div class="slimscrollright" style="overflow: hidden; width: auto; height: 100%;">

            <div class="rpanel-title"><i class="ti-filter text-white"></i> <?= Yii::t('app', 'view.filters') ?><span><i class="ti-close open-filter"></i></span></div>

            <div class="r-panel-body">

                <?php Pjax::begin(['id' => 'search-form']) ?>

                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => ['data-pjax' => true]
                ]); ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'is_active')->dropDownList([1 =>Yii::t('app', 'view.yes'), 0 => Yii::t('app', 'view.no')], ['prompt' => '']); ?>

                <div class="form-group pull-right">

                    <?= Html::a(Yii::t('app', 'view.clean'), ['index'], ['class' => 'btn btn-default']) ?>

                    <?= Html::submitButton(Yii::t('app', 'view.search'), ['class' => 'btn btn-success']) ?>

                </div>

                <?php ActiveForm::end(); ?>

                <?php Pjax::end() ?>

            </div>

        </div>

        <div class="slimScrollBar" style="background: rgb(220, 220, 220); width: 5px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 381.574px;"></div>

        <div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>

    </div>

</div>