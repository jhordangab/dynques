<?php

$this->title = Yii::t('app', 'view.my_profile');
$this->params['breadcrumbs'][] = $this->title

?>

<div class="usuario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
