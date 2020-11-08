<?php

$this->title = 'Cadastrar Pergunta';
$this->params['breadcrumbs'][] = ['label' => 'Perguntas', 'url' => ['index', 'id_form' => $model->id_form]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="question-create">

    <div class="row">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>