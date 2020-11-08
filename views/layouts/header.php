<?php 

$language = Yii::$app->session->get('language');

$icon = "/img/pt.png";

if($language == 'en')
{
    $icon = "/img/en.png";
}
elseif($language == 'es')
{
    $icon = "/img/es.png";
}

?>

<header class="topbar">

    <nav class="navbar top-navbar navbar-expand-md navbar-light">

        <div class="navbar-header">

            <a class="navbar-brand" href="/">
                
                <img class="img-responsive logo-lg" style="width: 100px;" src="/img/logo-white-mini.png" alt="homepage" />
                
                <img class="img-responsive logo-mini" src="/img/logo-white-mini.png" alt="homepage" width="50px" height="50px" style="display:none;" />
            
            </a>

        </div>

        <div class="navbar-collapse">

            <ul class="navbar-nav mr-auto mt-md-0">

                <li class="nav-item">

                    <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> 

                </li>

                <li class="nav-item"> 

                    <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> 

                </li>

            </ul>

            <ul class="navbar-nav my-lg-0">

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" style="font-size: 12px;" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?= $icon ?>" style="width: 20px" alt="user" class="profile-pic" />
                        <?= Yii::t('app', 'view.welcome') ?>, <?= (Yii::$app->user->identity) ? Yii::$app->user->identity->name : '' ?>!
                    </a>

                    <div class="dropdown-menu dropdown-menu-right scale-up">

                        <ul class="dropdown-user">

                            <li>
                                <div class="dw-user-box">
                                    <div class="u-text pl-0">
                                        <h5><?= (Yii::$app->user->identity) ? Yii::$app->user->identity->name : '' ?></h5>
                                        <p class="text-muted" style="font-size: 10px;"><?= (Yii::$app->user->identity) ? Yii::$app->user->identity->email : '' ?></p>
                                </div>
                            </li>
                            
                            <li role="separator" class="divider"></li>
                            
                            <li><a href="/my-profile"><i class="ti-user"></i> <?= Yii::t('app', 'view.update_profile') ?></a></li>
                            
                            <li role="separator" class="divider"></li>

                            <li><a href="/site/logout"><i class="fa fa-power-off"></i> <?= Yii::t('app', 'view.logout') ?></a></li>

                        </ul>

                    </div>

                </li>

            </ul>

        </div>

    </nav>

</header>