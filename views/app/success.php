<?php

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="area">

    <div class="row">

        <div class="col s12 m6 card pl-0 pr-0">

            <div class="card-header" style="background: #1761a0">

                <h3 class="text-white m-b-0 m-t-0"><img style="width: 50px;" src="/img/logo-white-mini.png"> <?= $this->title ?></h3>

            </div>

            <div class="p-4" id="render-dynamic-form">

                <div class="alert alert-success"><?= Yii::t('app', 'view.quiz_done') ?></div>

            </div>

        </div>

    </div>

</div>
