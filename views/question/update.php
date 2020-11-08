<?php

$this->title = Yii::t('app', 'view.update_question') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'view.questions'), 'url' => ['index', 'id_form' => $model->id_form]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'view.update_question');

?>

<div class="question-update">

    <div class="row">

        <?= $this->render('_form', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]) ?>

    </div>

</div>
