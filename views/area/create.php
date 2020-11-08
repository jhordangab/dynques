<?php

$this->title = Yii::t('app', 'view.insert_area');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'view.areas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="area-create">

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