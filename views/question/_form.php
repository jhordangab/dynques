<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\switchinput\SwitchInput;
use kartik\helpers\Html;
use app\helpers\FormHelper;
use yii\widgets\Pjax;

?>

<div class="col-lg-12 col-md-12">

    <div class="card card-outline-plan">

        <div class="card-body">

            <?php $form = ActiveForm::begin(); ?>

                <?= Form::widget(
                    [
                        'model' => $model,
                        'form' => $form,
                        'columns' => 12,
                        'attributes' =>
                            [
                                'order' =>
                                    [
                                        'type' => Form::INPUT_TEXT,
                                        'options' => ['type' => 'number'],
                                        'columnOptions' => ['colspan' => 2],
                                    ],
                                'name' =>
                                    [
                                        'type' => Form::INPUT_TEXT,
                                        'columnOptions' => ['colspan' => 6],
                                    ],
                                'type' =>
                                    [
                                        'type' => Form::INPUT_DROPDOWN_LIST,
                                        'items' => FormHelper::getCampos(),
                                        'options' =>
                                            [
                                                'prompt' => ''
                                            ],
                                        'columnOptions' => ['colspan' => 4],
                                    ],
                            ],
                    ]); ?>

                <?= Form::widget(
                    [
                        'model' => $model,
                        'form' => $form,
                        'columns' => 12,
                        'attributes' =>
                            [
                                'size' =>
                                    [
                                        'type' => Form::INPUT_TEXT,
                                        'columnOptions' => ['colspan' => 2],
                                    ],
                                'default' =>
                                    [
                                        'type' => Form::INPUT_TEXT,
                                        'columnOptions' => ['colspan' => 4],
                                    ],
                                'help' =>
                                    [
                                        'type' => Form::INPUT_TEXT,
                                        'columnOptions' => ['colspan' => 6],
                                    ],
                            ],
                    ]); ?>

                <?= Form::widget(
                    [
                        'model' => $model,
                        'form' => $form,
                        'columns' => 12,
                        'attributes' =>
                            [
                                'is_mandatory' =>
                                    [
                                        'type' => Form::INPUT_WIDGET,
                                        'columnOptions' => ['colspan' => 4],
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
                                    ],
                                'is_active' =>
                                    [
                                        'type' => Form::INPUT_WIDGET,
                                        'columnOptions' => ['colspan' => 4],
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
                                    ]
                            ],
                    ]); ?>

                <?= Html::submitButton(Yii::t('app', 'view.save'),
                    [
                        'class' => 'btn btn-success pull-right ml-3',
                    ]); ?>

                <?= Html::a(Yii::t('app', 'view.cancel'), ['index', 'id_form' => $model->id_form],
                    [
                        'class' => 'btn btn-default pull-right',
                    ]); ?>

                <?php ActiveForm::end(); ?>

            </div>

        </div>

    </div>

    <?php if($model->id): ?>

        <?php Pjax::begin(['id' => 'tabularpjax']); ?>

            <?= $this->render('_partial/_tabular', [
                'model' => $model,
                'dataProvider' => $dataProvider
            ])?>

        <?php Pjax::end(); ?>

    <?php endif; ?>

</div>
