<?php

$this->title = Yii::t('app', 'view.homepage');
$this->params['breadcrumbs'][] = $this->title;

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

        <?php foreach($areas as $area): ?>

            <div class="col-sm-12 col-lg-4 col-md-6 card m-2 p-3">

                <div class="card-content white-text">

                    <h3 class="text-themecolor m-b-0 m-t-0"><?= $area->name ?></h3>

                    <p><?= $area->description ?></p>

                </div>

                <div class="card-action">

                    <a class="btn btn-success mt-2" href="/my-quiz/index?id=<?= $area->id ?>"><?= Yii::t('app', 'view.view') ?></a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>
