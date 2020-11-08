<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use app\helpers\FormHelper;

$this->title = 'Perguntas';
$this->params['breadcrumbs'][] = ['label' => 'Formulário:: ' . $form->name, 'url' => ['/form/index']];
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

$columns[] = 'order';

$columns[] = 'name';

$columns[] =
    [
        'attribute' => 'type',
        'filter' => FormHelper::getCampos(),
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['style' => 'width: 10%;', 'class' => 'text-center'],
        'value' => function ($model)
        {
            $campos = FormHelper::getCampos();
            return (isset($campos[$model->type])) ? $campos[$model->type] : '';
        }
    ];

$columns[] =
    [
        'attribute' => 'is_mandatory',
        'format' => 'boolean',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['style' => 'width: 10%;', 'class' => 'text-center'],
    ];

$columns[] =
    [
        'attribute' => 'is_active',
        'format' => 'boolean',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['style' => 'width: 10%;', 'class' => 'text-center'],
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
                        'class' => 'delete-question',
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
   
    $(document).delegate('.delete-question', 'click', function (e) 
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
                    url: '/question/delete?id=' + _id,
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

<div class="question-index">

    <div class="row">

        <div class="col-lg-12 col-md-12">

            <div class="card card-outline-plan">

                <div class="card-body">

                    <?= Html::a(Yii::t('app', 'view.create'), ['create', 'id_form' => $form->id], ['id' => 'btn-question', 'class' => 'btn btn-success btn-default float-right ml-2', 'data-pjax' => 0]); ?>

                    <?=  ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'filename' => 'Dynques_Pergunta_' . date('d_m_Y'),
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
                                'order',
                                'name',
                                'type',
                                'is_mandatory:boolean',
                                'is_active:boolean',
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