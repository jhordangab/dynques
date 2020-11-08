<?php

use yii\helpers\Html;

?>

<?php $this->beginPage() ?>

<!doctype html>
<html lang="<?= Yii::$app->language ?>">
    
    <head>
    
        <meta charset="<?= Yii::$app->charset ?>">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <?= Html::csrfMetaTags() ?>
        
        <title>Dynques - <?= Html::encode($this->title) ?></title>

        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
        
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        
        <link rel="stylesheet" href="/css/iziToast.min.css">
        
        <link rel="stylesheet" href="/css/login.css">
        
        <?php $this->head() ?>
    
    </head>

    <body>
        
        <?php $this->beginBody() ?>

        <div class="container-fluid bp1-application">
            
            <div class="row h-100">
            
                <div class="col-lg-4 col-xl-4 hidden-md-down login--sidebar">
                
                    <div class="row h-100 justify-content-center">
                    
                        <div class="col-8 align-self-center">

                            <div class="text-hide">
                                <img style="width: 100%;" src="/img/logo-white-mini.png">
                            </div>
                            
                        </div>
                    
                    </div>
                
                </div>
                
                <div class="col-lg-8 col-xl-8 justify-content-center login--content">
                
                    <?php

                        if (Yii::$app->session->hasFlash('toast-success')):

                            $message =  Yii::$app->session->getFlash('toast-success');

                            $js = "iziToast.success({
                                title: '{$message}',
                                position: 'topCenter',
                                close: true,
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX',
                            });";

                            $this->registerJs($js);

                        endif;

                    ?>
                    
                    <?= $content ?>

                </div>

            </div>

        </div>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js "></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js "></script>

        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js " integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn " crossorigin="anonymous "></script>

        <script type="text/javascript" src="/js/iziToast.min.js"></script>
        
        <?php $this->endBody() ?>
        
    </body>

</html>

<?php $this->endPage() ?>
