<?php

use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;

$url_new_question = Yii::$app->urlManager->createUrl('question/new-option?question_id=' . $model->id);
$delete_message = Yii::t('app', 'view.delete');
$confirm_message = Yii::t('app', 'view.confirm_del');
$confirm_button = Yii::t('app', 'view.yes');
$cancel_button = Yii::t('app', 'view.cancel');

$script = <<< JS

    $(document).on('click', '.quick-add-option', function () 
    {       
        $('#addOptionFormModel').modal('show').find('.modal-dialog').load('$url_new_question');
    });

    $(document).delegate('.delete-option', 'click', function (e) 
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
                    url: '/question/delete-option?id=' + _id,
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

$this->registerJs($script);

$tabular_attributes = [
    'code' => ['type' => TabularForm::INPUT_TEXT],
    'value' => ['type' => TabularForm::INPUT_TEXT],
];

?>

<div class="modal inmodal" id="addOptionFormModel" role="dialog" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-md "></div>

</div>

<div class="col-lg-12 col-md-12 mt-3">

    <div class="card card-outline-plan">

        <div class="card-body text-center">

            <h5 class="text-center"><?= Yii::t('app', 'view.parameters') ?></h5>

            <?php $form = ActiveForm::begin(); ?>

            <?=

            TabularForm::widget([
                'dataProvider' => $dataProvider,
                'form' => $form,
                'attributes' => $tabular_attributes,
                'checkboxColumn' => false,
                'actionColumn' => [
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
                                    'class' => 'delete-option',
                                    'data-id' => $model->id,
                                    'data-title' => $model->value
                                ]);
                            },
                        ]
                ],
                'gridSettings' =>
                    [
                        'condensed' => true,
                        'floatHeader' => true,
                        'panel' => [
                            'before' => false,
                            'footer' => false,
                            'type' => GridView::TYPE_PRIMARY,
                            'after'=> Html::a(Yii::t('app', 'view.create'), '#', ['class'=>'btn btn-success pull-right ml-2 quick-add-option']) . ' ' .
                                Html::submitButton(Yii::t('app', 'view.save'), ['class'=>'btn btn-success pull-right ml-2'])
                        ]
                    ]
            ]);

            ?>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>