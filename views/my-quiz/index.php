<?php

$this->title = $area->name . ' - ' . Yii::t('app', 'geral.quiz');
$this->params['breadcrumbs'][] = $this->title

?>

<style>

    .card .card-action:last-child {
        border-radius: 0 0 2px 2px;
    }
    .card .card-action {
        background-color: inherit;
        border-top: 1px solid rgba(160,160,160,0.2);
        position: relative;
        text-align: right;
    }

</style>

<div class="area">

    <div class="row">

        <?php foreach($quizz as $quiz): ?>

            <div class="col-sm-12 col-lg-3 col-md-6 card m-2 p-3">

                <div class="card-header" style="background: #1761a0">

                    <h3 class="text-center text-white m-b-0 m-t-0"><i class="mdi mdi-clipboard-text"></i> <?= $quiz->name ?></h3>

                </div>

                <div class="card-content white-text mt-3">

                    <p><?= $quiz->description ?></p>

                </div>

                <div class="card-action">

                    <a class="btn btn-success mt-2" href="/app/main?id_quiz=<?= $quiz->id ?>"><?= Yii::t('app', 'view.share') ?></a>

                    <a class="btn btn-default mt-2" href="#"><?= Yii::t('app', 'view.view') ?></a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>
