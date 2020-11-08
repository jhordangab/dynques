<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\FormHelper;

$this->title = 'Pergunta: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Perguntas', 'url' => ['index', 'id_form' => $model->id_form]];
$this->params['breadcrumbs'][] = $this->title;

$campos = FormHelper::getCampos();

?>

<div class="form-view">

    <div class="row">

        <div class="col-lg-12 col-md-12">

            <div class="card card-outline-plan">

                <div class="card-body">

                    <?= Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app', 'view.back'), ['index', 'id_form' => $model->id_form],
                        [
                            'class' => 'btn btn-sm btn-light pull-right mb-2'
                        ]); ?>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' =>
                            [
                                'order',
                                'name',
                                [
                                    'attribute' => 'type',
                                    'value' => (isset($campos[$model->type])) ? $campos[$model->type] : ''
                                ],
                                'help',
                                'default',
                                'size',
                                'is_mandatory:boolean',
                                'is_active:boolean'
                            ],
                    ]) ?>

                </div>

            </div>

        </div>

    </div>

</div>