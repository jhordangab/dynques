<?php

use app\assets\AppAsset;
use yii\helpers\Html;

if (Yii::$app->controller->action->id === 'login')
{ 
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} 
else 
{

    AppAsset::register($this);

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
    
    .datepicker table tr td span.active:active, .datepicker table tr td span.active:hover:active, .datepicker table tr td span.active.disabled:active, .datepicker table tr td span.active.disabled:hover:active, .datepicker table tr td span.active.active, .datepicker table tr td span.active:hover.active, .datepicker table tr td span.active.disabled.active, .datepicker table tr td span.active.disabled:hover.active,
    .datepicker table tr td.active:active:hover, .datepicker table tr td.active.highlighted:active:hover, .datepicker table tr td.active.active:hover, .datepicker table tr td.active.highlighted.active:hover, .datepicker table tr td.active:active:focus, .datepicker table tr td.active.highlighted:active:focus, .datepicker table tr td.active.active:focus, .datepicker table tr td.active.highlighted.active:focus, .datepicker table tr td.active:active.focus, .datepicker table tr td.active.highlighted:active.focus, .datepicker table tr td.active.active.focus, .datepicker table tr td.active.highlighted.active.focus,
    .datepicker table tr td.active:active, .datepicker table tr td.active.highlighted:active, .datepicker table tr td.active.active, .datepicker table tr td.active.highlighted.active,
    .datepicker table tr td.today, .datepicker table tr td.today.disabled, .datepicker table tr td.today.disabled:hover, .datepicker table tr td.today:hover 
    {
        background: #1761a0 !important;
        color: #ffffff;
        border-color: #1761a0 !important;
    }
            
    a, a:hover 
    {
        color: #1761a0;
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
            
    [type="checkbox"]:not(:checked), [type="checkbox"]:checked
    {
        position: absolute;
        left: unset;
        opacity: 1;
    }
            
    .modal.show .modal-dialog
    {
        box-shadow: 0 30px 80px rgba(0,0,0,.5);
        border-radius: 8px;
    }
            
    .modal-content 
    {
        border-radius: 8px;
    }
            
    .popover-body 
    {
        padding: 0px;
    }
            
    .pointer
    {
        cursor: pointer;
    }
            
    .sidebar-nav ul li a.active, .sidebar-nav ul li a:hover
    {
        background-color: #1761a029;
    }
            
    .main-footer
    {
        background: #f0f6fa;
        padding: 15px;
        font-size: 10px;
        color: #444;
    }
            
    .main-footer 
    {
        -webkit-transition: -webkit-transform .3s ease-in-out,margin .3s ease-in-out;
        -moz-transition: -moz-transform .3s ease-in-out,margin .3s ease-in-out;
        -o-transition: -o-transform .3s ease-in-out,margin .3s ease-in-out;
        transition: transform .3s ease-in-out,margin .3s ease-in-out;
        margin-left: 230px;
        z-index: 820;
    }
            
    body.mini-sidebar img.logo-mini
    {
        display: initial !important;
    }
            
    body.mini-sidebar img.logo-lg
    {
        display: none !important;
    }
            
    .spectrum-input
    {
        background-color: transparent !important;
        border: none;
        color: #67757c;
    }
            
    .table th, .table td
    {
        vertical-align: middle;
    }
           
    .right-sidebar .rpanel-title 
    {
        background: #1761a0;
        height: 70px;
    }
            
CSS;

$this->registerCss($css);

?>

    <?php $this->beginPage() ?>

        <!DOCTYPE html>
        <html lang="<?= Yii::$app->language ?>" style="background-color: #eef5f9;">

            <head>

                <meta charset="<?= Yii::$app->charset ?>"/>

                <meta name="viewport" content="width=device-width, initial-scale=1">

                <?= Html::csrfMetaTags() ?>

                <title>Dynques - <?= Html::encode($this->title) ?></title>

                <link rel="shortcut icon" href="/favicon.ico" />

                <?php $this->head() ?>

            </head>

            <body class="fix-header fix-sidebar card-no-border">

                <?php $this->beginBody() ?>
                
                    <div id="main-wrapper h-100">

                        <?= $this->render('header.php'); ?>

                        <?= $this->render('left.php'); ?>
                        
                        <div class="div-loading"></div>

                        <?= $this->render('content.php', ['content' => $content]); ?>

                        <?= $this->render('footer.php'); ?>
                        
                    </div>

                <?php $this->endBody() ?>

            </body>
            
        </html>
        
    <?php $this->endPage() ?>

<?php } ?>
