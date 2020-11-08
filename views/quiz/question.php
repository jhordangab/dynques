<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'view.questions') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'view.quizs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quiz-index">

    <div class="row">

        <div class="col-lg-12 col-md-12">

            <div class="card card-outline-plan">

                <div class="card-body">

                    <?php Pjax::begin(['id' => 'treepjax']); ?>

                        <?= $this->render('_partial/_tree', [
                            'model' => $model,
                            'nodes' => $nodes,
                            'has_questions' => $has_questions
                        ])?>

                    <?php Pjax::end(); ?>

                </div>

            </div>

        </div>

    </div>

</div>