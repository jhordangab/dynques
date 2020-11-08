<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\helpers\Html;

?>

<div class="usuario-form">

    <div class="card">
            
        <div class="card-body">
            
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
                            'columnOptions' => ['colspan' => 6],
                        ],
                        'login' =>
                        [
                            'type' => Form::INPUT_TEXT,
                            'columnOptions' => ['colspan' => 3],
                        ],
                        'language' =>
                        [
                            'type' => Form::INPUT_DROPDOWN_LIST,
                            'items' => [
                                'PT' => Yii::t('app', 'view.portuguese'),
                                'EN' => Yii::t('app', 'view.english'),
                                'ES' => Yii::t('app', 'view.spanish')
                            ],
                            'columnOptions' => ['colspan' => 3],
                        ]
                    ],
                ]); ?>

                <hr>

                <?= Form::widget(
                [
                    'model' => $model,
                    'form' => $form,
                    'columns' => 12,
                    'attributes' =>
                    [
                        'cell' =>
                        [
                            'type' => Form::INPUT_WIDGET, 
                            'widgetClass' => yii\widgets\MaskedInput::classname(),
                            'options' => ['mask' => '(99) 99999-9999'],
                            'columnOptions' => ['colspan' => 3],
                        ],
                        'email' =>
                        [
                            'type' => Form::INPUT_TEXT,
                            'options' => ['type' => 'email'],
                            'columnOptions' => ['colspan' => 3],
                        ],
                        'new_password' =>
                        [
                            'type' => Form::INPUT_PASSWORD,
                            'columnOptions' => ['colspan' => 3],
                        ],     
                        'repete_new_password' =>
                        [
                            'type' => Form::INPUT_PASSWORD,
                            'columnOptions' => ['colspan' => 3],
                        ],

                    ],
                ]); ?>

                <?= Html::submitButton(Yii::t('app', 'view.save'),
                [
                    'class' => 'btn btn-success pull-right',
                ]); ?>

            <?php ActiveForm::end(); ?>
                
        </div>
        
    </div>

</div>