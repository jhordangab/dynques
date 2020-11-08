<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = 
    [
        '/css/style.css',
        '/css/colors/blue.css',
        '/cassets/plugins/sweetalert/sweetalert.css',
        '/css/site.css',
        '/css/iziToast.min.css',
        'css/swal.min.css',
        '/css/connectors.css',
        '/css/treant.css',
        '/icheck/skins/square/blue.css',
        '/signature/assets/jquery.signaturepad.css',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css'
    ];

    public $js = 
    [
        "/js/jquery.slimscroll.js",
        "/js/waves.js",
        "/js/sidebarmenu.js",
        "/cassets/plugins/sweetalert/sweetalert.min.js",
        "/cassets/plugins/sticky-kit-master/dist/sticky-kit.min.js",
        "/cassets/plugins/sparkline/jquery.sparkline.min.js",
        "/js/custom.js",
        "/cassets/plugins/c3-master/c3.min.js",
        "/cassets/plugins/styleswitcher/jQuery.style.switcher.js",
        "/cassets/plugins/nestable/jquery.nestable.js",
        "/cassets/plugins/sweetalert/sweetalert.min.js",
        "/cassets/plugins/wizard/jquery.steps.min.js",
        "/cassets/plugins/wizard/jquery.validate.min.js",
        "/js/iziToast.min.js",
        'js/swal.min.js',
        "/js/jquery.floatThead.js",
        "/js/jquery.treegrid.min.js",
        "/js/jquery.treegrid.bootstrap3.js",
        "/js/raphael.js",
        "/js/Treant.js",
        "/icheck/icheck.min.js",
        "/signature/jquery.signaturepad.js",
        "/signature/assets/json2.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"
    ];
    
    public $depends = 
    [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\JqueryAsset'
    ];
}
