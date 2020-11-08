<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'view.quiz') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'view.quizs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quiz-view">

    <div class="row">

        <div class="col-lg-12 col-md-12">

            <div class="card card-outline-plan">

                <div class="card-body">

                    <?= Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app', 'view.back'), ['index'],
                        [
                            'class' => 'btn btn-sm btn-light pull-right mb-2'
                        ]); ?>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' =>
                            [
                                [
                                    'attribute' => 'id_area',
                                    'value' => $model->area->name
                                ],
                                'order',
                                'name',
                                'description',
                                'is_active:boolean'
                            ],
                    ]) ?>

                </div>

            </div>

        </div>

    </div>

</div>