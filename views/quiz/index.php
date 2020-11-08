<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\Area;

$this->title = 'Quiz';
$this->params['breadcrumbs'][] = $this->title;

$css = <<<CSS
        
    .table td
    {
        padding: 0.5rem;
    }
        
CSS;

$this->registerCss($css);

$this->registerJs(

    '$("document").ready(function(){ 

        $("#search-form").on("pjax:end", function() {

            $.pjax.reload({container:"#gridData"});

        });

    });'

);

$columns = [];

$user_id = Yii::$app->user->identity->id;

$columns[] =
    [
        'attribute' => 'id_area',
        'group' => true,
        'filter' => ArrayHelper::map(Area::find()->andWhere(['id_user' => $user_id, 'is_active' => TRUE, 'is_deleted' => FALSE])->orderBy('order ASC')->all(), 'id', 'name'),
        'value' => function($model)
        {
            return $model->area->name;
        },
    ];


$columns[] =
    [
        'attribute' => 'order',
        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
        'contentOptions' => ['style' => 'text-align: center;']
    ];

$columns[] = 'name';


$columns[] =
    [
        'attribute' => 'is_active',
        'format' => 'boolean',
        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
        'contentOptions' => ['style' => 'text-align: center;']
    ];

$columns[] =
    [
        'class' => 'kartik\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:10%; text-align: center;'],
        'headerOptions' => ['style' => 'width:10%; text-align: center;'],
        'header' => Yii::t('app', 'view.view'),
        'template' => '{view}',
        'buttons' =>
            [
                'view' => function ($url, $model)
                {
                    return Html::a('<span class="fa fa-eye"></span>', $url, [
                        'title' => Yii::t('app', 'view.view'),
                    ]);
                }
            ]
    ];

$columns[] =
    [
        'class' => 'kartik\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:10%; text-align: center;'],
        'headerOptions' => ['style' => 'width:10%; text-align: center;'],
        'header' => Yii::t('app', 'view.configure'),
        'template' => '{question}',
        'buttons' =>
            [
                'question' => function ($url, $model)
                {
                    return Html::a('<span class="fa fa-cogs"></span>', $url, [
                        'title' => Yii::t('app', 'view.configure'),
                    ]);
                }
            ]
    ];

$columns[] =
    [
        'class' => 'kartik\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:10%; text-align: center;'],
        'headerOptions' => ['style' => 'width:10%; text-align: center;'],
        'header' => Yii::t('app', 'view.update'),
        'template' => '{update}',
        'buttons' =>
            [
                'update' => function ($url, $model)
                {
                    return Html::a('<span class="fa fa-edit"></span>', $url, [
                        'title' => Yii::t('app', 'view.update'),
                    ]);
                }
            ]
    ];

$columns[] =
    [
        'class' => 'kartik\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:10%; text-align: center;'],
        'headerOptions' => ['style' => 'width:10%; text-align: center;'],
        'header' => Yii::t('app', 'view.delete'),
        'template' => '{delete}',
        'buttons' =>
            [
                'delete' => function ($url, $model) {
                    return Html::a('<i class="fa fa-trash"></i>', 'javascript:', [
                        'title' => Yii::t('app', 'view.delete'),
                        'class' => 'delete-quiz',
                        'data-id' => $model->id,
                        'data-title' => $model->name
                    ]);
                },
            ]
    ];

$delete_message = Yii::t('app', 'view.delete');
$confirm_message = Yii::t('app', 'view.confirm_del');
$confirm_button = Yii::t('app', 'view.yes');
$cancel_button = Yii::t('app', 'view.cancel');

$js = <<<JS
   
    $(document).delegate('.delete-quiz', 'click', function (e) 
    {
        e.preventDefault();
        var _id = $(this).data('id');
        
        swal({
            title: '{$delete_message}',
            text: "{$confirm_message}",
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: '{$cancel_button}',
            confirmButtonColor: '#227584',
            confirmButtonText: '{$confirm_button}'
        }).then((result) => 
        {
            if (result.value) 
            {
                $.ajax({
                    url: '/quiz/delete?id=' + _id,
                    type: 'GET',
                    success: function (_data) 
                    {
                        location.reload();
                    }
                })
            }
        })
    });
        
JS;

    $this->registerJs($js);

?>

<div class="quiz-index">

    <div class="row">

        <div class="col-lg-12 col-md-12">

            <div class="card card-outline-plan">

                <div class="card-body">

                    <?= Html::a(Yii::t('app', 'view.create'), ['create'], ['class' => 'btn btn-success btn-default float-right ml-2', 'data-pjax' => 0]); ?>

                    <?= $this->render('_search', ['model' => $searchModel]); ?>

                    <?=  ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'filename' => 'Dynques_Dynques_' . date('d_m_Y'),
                        'exportConfig' =>
                            [
                                ExportMenu::FORMAT_HTML => [],
                                ExportMenu::FORMAT_CSV => [],
                                ExportMenu::FORMAT_TEXT => [],
                                ExportMenu::FORMAT_PDF => [],
                                ExportMenu::FORMAT_EXCEL_X => [],
                                ExportMenu::FORMAT_EXCEL => FALSE
                            ],
                        'fontAwesome' => true,
                        'container' => ['class'=>'btn-group pull-right', 'role' => 'group'],
                        'columns' =>
                            [
                                [
                                    'attribute' => 'id_area',
                                    'value' => function ($model)
                                    {
                                        return $model->area->name;
                                    }
                                ],
                                'order',
                                'name',
                                'is_active:boolean'
                            ],
                        'dropdownOptions' =>
                            [
                                'label' => Yii::t('app', 'view.export'),
                                'class' => 'btn btn-success'
                            ]
                    ]) ?>

                    <?php Pjax::begin(['id' => 'gridData']) ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout'=> "{items}<div class='row'><div class='col-lg-6'>{pager}</div><div class='col-lg-6 text-right'>{summary}</div></div>",
                        'columns' => $columns
                    ]); ?>

                    <?php Pjax::end() ?>

                </div>

            </div>

        </div>

    </div>

</div>