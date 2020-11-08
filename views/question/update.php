<?php

$this->title = 'Alterar Pergunta: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Perguntas', 'url' => ['index', 'id_form' => $model->id_form]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Alterar Pergunta';

?>

<div class="question-update">

    <div class="row">

        <?= $this->render('_form', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]) ?>

    </div>

</div>
