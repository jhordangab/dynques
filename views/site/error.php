<?php

use yii\helpers\Html;

$this->title = $code;

?>

<div class="site-error">

    <h1><?= Html::encode($code) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

</div>
