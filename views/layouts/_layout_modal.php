<?php

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
$this->beginPage();

$css = <<<CSS
     
    .btn.btn-success 
    {
        color: #fff;
        background-color: #1761a0;
        border-color: #1761a0;
    }
        
    .has-success .form-control 
    {
        border-color: #1761a0;
    }
        
    .has-error .form-control 
    {
        border-color: #d00326;
    }
        
    .help-block
    {
        color: #d00326;
    }
        
    .div-loading
    {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('/img/loading.gif') 
                    50% 50% 
                    no-repeat;
    }

    .div-loading.loading 
    {
        overflow: hidden;   
    }

    .div-loading.loading
    {
        display: block;
    }
        
CSS;

$this->registerCss($css);

?>

<?php $this->beginPage() ?>

<html>

    <head>

        <?php $this->head();?>

        <?= Html::csrfMetaTags(); ?>

    </head>

    <body style="background-color: #fff;">

        <?php $this->beginBody() ?>

            <?php if (Yii::$app->session->getAllFlashes()) : ?>

                <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) : ?>

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <div class="alert alert-<?= $key; ?>"> <?= $message; ?> </div>

                <?php endforeach; ?>
                        
            <?php else: ?>

                <div class="div-loading"></div>

                <?= $content; ?>

            <?php endif; ?>
			        
        <?php $this->endBody() ?>
                
    </body>
    
</html>

    <?php $this->endPage() ?>

	