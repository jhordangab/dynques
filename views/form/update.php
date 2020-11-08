<?php

$this->title = Yii::t('app', 'view.update_form') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'view.forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'view.update_form');

?>

<div class="form-update">

    <div class="row">

        <div class="col-lg-12 col-md-12">

            <div class="card card-outline-plan">

                <div class="card-body">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>

            </div>

        </div>

    </div>

</div>
