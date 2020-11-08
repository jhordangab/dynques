<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\helpers\Html;
use kartik\switchinput\SwitchInput;

?>

<div class="col-lg-12">

    <?php $form = ActiveForm::begin(); ?>

    <?= Form::widget(
        [
            'model' => $model,
            'form' => $form,
            'columns' => 12,
            'attributes' =>
                [
                    'name' =>
                        [
                            'type' => Form::INPUT_TEXT,
                            'columnOptions' => ['colspan' => 12],
                        ],
                ],
        ]); ?>


    <?= Form::widget(
        [
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' =>
                [
                    'description' =>
                        [
                            'type' => Form::INPUT_TEXTAREA,
                            'options' => ['rows' => 3],
                        ]
                ],
        ]); ?>

    <?= Form::widget(
        [
            'model' => $model,
            'form' => $form,
            'columns' => 12,
            'attributes' =>
                [
                    'is_active' =>
                        [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => SwitchInput::classname(),
                            'options' =>
                                [
                                    'pluginOptions' =>
                                        [
                                            'size' => 'mini',
                                            'onText' => Yii::t('app', 'view.yes'),
                                            'offText' => Yii::t('app', 'view.no'),
                                            'onColor' => 'success',
                                            'offColor' => 'danger',
                                        ],
                                ],
                            'columnOptions' => ['colspan' => 4],
                        ],
                ],
        ]); ?>

    <?= Html::submitButton(Yii::t('app', 'view.save'),
        [
            'class' => 'btn btn-success pull-right ml-3',
        ]); ?>

    <?= Html::a(Yii::t('app', 'view.cancel'), ['index'],
        [
            'class' => 'btn btn-default pull-right',
        ]); ?>

    <?php ActiveForm::end(); ?>

</div>
