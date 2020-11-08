<?php

$this->title = Yii::t('app', 'view.insert_question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'view.questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="question-create">

    <div class="row">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>