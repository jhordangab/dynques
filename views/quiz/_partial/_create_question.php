<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Category;

$user_id = Yii::$app->user->id;

?>

<div class="modal-content animated bounceInTop" >
    <?php
    $form = ActiveForm::begin(['id' => 'form-add-question', 'enableAjaxValidation' => true, 'validationUrl' => Yii::$app->urlManager->createUrl('quiz/question-validate')]);
    ?>
    <div class="modal-header">
        <h4 class="modal-title text-left" style="color: #fdd42f;"><?= Yii::t('app', 'geral.question') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'id_category')->dropDownList(ArrayHelper::map(Category::find()->andWhere(['id_user' => $user_id, 'is_active' => TRUE, 'is_deleted' => FALSE])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '']) ?>
        <?php echo $form->field($model, 'description')->textArea() ?>
        <div class="text-right">
            <?= Html::submitButton(Yii::t('app', 'view.save'), ['class' => 'btn btn-success ml-2']) ?>
            <button  type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'view.cancel') ?></button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS

   $(document).ready(function () { 
        $("#form-add-question").on('beforeSubmit', function (event) { 
            event.preventDefault();            
            var form_data = new FormData($('#form-add-question')[0]);
            $.ajax({
                   url: $("#form-add-question").attr('action'), 
                   dataType: 'JSON',  
                   cache: false,
                   contentType: false,
                   processData: false,
                   data: form_data,                     
                   type: 'post',                        
                   beforeSend: function() {
                   },
                   success: function(response){    
                       if(response.status == "success")
                       {
                           $('#addQuestionFormModel').modal('hide');
                           $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();

                           iziToast.success({
                                title: response.message,
                                position: 'topCenter',
                                close: true,
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX',
                            });
                       }
                       
                       if(response.status == "error")
                       {
                           iziToast.error({
                                title: response.message,
                                position: 'topCenter',
                                close: true,
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX',
                            });
                       }
                       
                   },
                   complete: function() {
                       $.pjax.reload({container:"#treepjax"});
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
    });       

JS;
$this->registerJs($script);
?>