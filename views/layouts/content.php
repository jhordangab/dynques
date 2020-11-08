<?php

use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;

?>

<div class="page-wrapper">

    <div class="container-fluid">

        <div class="row page-titles">
            
            <div class="col-md-5 col-8 align-self-center">
            
                <h3 class="text-themecolor m-b-0 m-t-0"><?= $this->title ?></h3>

                <?=
                Breadcrumbs::widget(
                    [
                        'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                        'activeItemTemplate' => "<li class='breadcrumb-item active'>{link}</li>\n",
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]
                ) ?>

            </div>
            
            <?php if(isset($this->context->hasFilter) && $this->context->hasFilter && Yii::$app->controller->action->id == 'index') : ?>

                <div class="col-md-7 col-4 align-self-center">

                    <div class="d-flex m-t-10 justify-content-end">

                        <div class="">

                        <button class="open-filter waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-filter text-white"></i></button>

                        </div>

                    </div>

                </div>
            
            <?php endif; ?>
            
        </div>
        
        <?php

            if (Yii::$app->session->hasFlash('success')):

                $message =  Yii::$app->session->getFlash('success');

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