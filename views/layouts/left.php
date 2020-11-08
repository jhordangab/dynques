<?php 

use app\models\Area;

$user_id = Yii::$app->user->identity->id;

$areas = Area::find()->andWhere([
    'is_active' => TRUE,
    'is_deleted' => FALSE,
    'id_user' => $user_id
])->orderBy('order ASC')->all();

?>
        
<aside class="left-sidebar" style="position: fixed;">

    <div class="slimScrollDiv">
        
        <div class="scroll-sidebar">

            <nav class="sidebar-nav">

                <ul id="sidebarnav" class="mt-3">

                    <div class="user-profile" style="">

                        <div class="profile-text">

                            <a href="javascript:" class="text-center text-uppercase" style="margin-top: 7px; cursor: text;"><?= Yii::t('app', 'geral.quizs') ?></a>

                        </div>

                    </div>

                    <?php foreach($areas as $area): ?>

                        <li>

                            <a class="waves-effect waves-dark area-box" href="/my-quiz?id=<?= $area->id ?>" aria-expanded="false">

                                <i class="mdi mdi-checkbox-blank-outline"></i>

                                <span class="hide-menu"><?= $area->name ?></span>

                            </a>

                        </li>

                    <?php endforeach; ?>

                    <?php

                    $js = <<<JS

                    $( document ).ready(function() {
                        $('.area-box.active').find('i.mdi-checkbox-blank-outline').removeClass('mdi-checkbox-blank-outline').addClass('mdi-checkbox-marked-outline');
                    });
                
JS;


                    $this->registerJs($js);

                    ?>

                    <div class="user-profile" style="">

                        <div class="profile-text">

                            <a href="javascript:" class="text-center text-uppercase" style="margin-top: 7px; cursor: text;"><?= Yii::t('app', 'geral.configurations') ?></a>

                        </div>

                    </div>

                    <li>

                        <a class="waves-effect waves-dark" href="/area" aria-expanded="false">

                            <i class="mdi mdi-lan"></i>

                            <span class="hide-menu"><?= Yii::t('app', 'geral.areas') ?></span>

                        </a>

                    </li>

                    <li>

                        <a class="waves-effect waves-dark" href="/category" aria-expanded="false">

                            <i class="mdi mdi-tag"></i>

                            <span class="hide-menu"><?= Yii::t('app', 'geral.categories') ?></span>

                        </a>

                    </li>

                    <li>

                        <a class="waves-effect waves-dark" href="/form" aria-expanded="false">

                            <i class="mdi mdi-clipboard-text"></i>

                            <span class="hide-menu"><?= Yii::t('app', 'geral.forms') ?></span>

                        </a>

                    </li>


                    <li>

                        <a class="waves-effect waves-dark" href="/quiz" aria-expanded="false">

                            <i class="mdi mdi-check-all"></i>

                            <span class="hide-menu"><?= Yii::t('app', 'geral.quizs') ?></span>

                        </a>

                    </li>

                </ul>

            </nav>
            
        </div>

    </div>

</aside>