<?php

use kartik\builder\Form;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\helpers\Html;

$js = <<<JS

$(document).ready(function(){
  $('.radio input, .checkbox input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%'
  });
});

$('#dynamicform-id_option .radio input').on('ifChecked', function(e){
    e.preventDefault();
    var form_data = new FormData($('#dynamic-form')[0]);
    var option_id = $(this).val();

    $.ajax({
       url: '/app/render-form?id_quiz={$model->id}&id_answer={$id_answer}&question_id={$dynamic->id}&option_id=' + option_id + '&t={$t}', 
       // dataType: 'JSON',  
       cache: false,
       contentType: false,
       processData: false,
       data: form_data,                     
       // type: 'POST',                 
       success: function(data){    
           $('#render-dynamic-form').html(data);
       },
       error: function (data) {
           iziToast.error({
                title: data.statusText,
                position: 'topCenter',
                close: true,
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
            });
       }
    });                
    return false;
});

JS;

$this->registerJs($js);

?>

<?php $form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'action' => '/app/main?id_quiz=' . $model->id . '&id_answer=' . $id_answer . '&question_id=' . $dynamic->id . '&t=' . $t,
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>

<?= $dynamic->renderDynamicFields($form); ?>

<?= Html::submitButton(Yii::t('app', 'view.next'),
    [
        'class' => 'btn btn-success pull-right ml-3',
    ]); ?>

<?php ActiveForm::end(); ?>
