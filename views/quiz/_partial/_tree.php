<?php

$delete_message = Yii::t('app', 'view.delete');
$confirm_message = Yii::t('app', 'view.confirm_del');
$confirm_button = Yii::t('app', 'view.yes');
$cancel_button = Yii::t('app', 'view.cancel');
$add_question = Yii::t('app', 'view.add_question');
$add_option = Yii::t('app', 'view.add_option');
$update = Yii::t('app', 'view.update');
$delete = Yii::t('app', 'view.delete');

$nodeStructure = json_encode($nodes);

$js = <<<'JS'

var chart_config = {
	chart: {
		container: "#quiz-question-node",
		levelSeparation: 45,
		rootOrientation: "NORTH",
		nodeAlign: "CENTER",
		connectors: {
			type: "step",
			style: {
				"stroke-width": 2
			}
		},
		node: {
			HTMLclass: "question-node"
		}
	},
	nodeStructure: 
JS;

$js .= $nodeStructure;

$js .= <<<'JS'

};

new Treant( chart_config );

$(function(){
    $.contextMenu({
        selector: '.question-node.option', 
        trigger: 'left',
        callback: function(key, options) {
            id = options.$trigger.attr("data-id");
            id_question = options.$trigger.attr("data-questionid");
            id_quiz = options.$trigger.attr("data-quizid");
            
            if(key == 'create')
            {
                $('#addOptionFormModel').modal('show').find('.modal-dialog').load('/quiz/new-question?quiz_id=' + id_quiz + '&option_id=' + id);
            }
            else if(key == 'edit')
            {
                $('#addOptionFormModel').modal('show').find('.modal-dialog').load('/quiz/update-option?id=' + id);
            }
            else if(key == 'delete')
            {
JS;

$js .= <<<JS
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
                            url: '/quiz/delete-option?id=' + id,
                            type: 'GET',
                            success: function (_data) 
                            {
                                 $.pjax.reload({container:"#treepjax"});
                            }
                        })
                    }
                });
            }
        },
        items: {
            "create": 
            {
                name: "{$add_question}",
                icon: "fa-plus", 
                visible: function(key, opt){      
                    
JS;

$js .= <<<'JS'
                    possui_proxima = opt.$trigger.attr("data-next");
                    return (possui_proxima == 'false');
                }
            },
JS;

$js .= <<<JS
            "edit": {name: "{$update}", icon: "edit"},
            "delete": {name: "$delete", icon: "delete"}
        }
    });

JS;

$js .= <<<'JS'
    
    $.contextMenu({
        selector: '.question-node.question', 
        trigger: 'left',
        callback: function(key, options) {
            id = options.$trigger.attr("data-id");
            id_quiz = options.$trigger.attr("data-quizid");
            
            if(key == 'create')
            {
                $('#addOptionFormModel').modal('show').find('.modal-dialog').load('/quiz/new-option?question_id=' + id);
            }
            else if(key == 'edit')
            {
                $('#addOptionFormModel').modal('show').find('.modal-dialog').load('/quiz/update-question?id=' + id);
            }
            else if(key == 'delete')
JS;

$js .= <<<JS
            {
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
                            url: '/quiz/delete-question?id=' + id,
                            type: 'GET',
                            success: function (_data) 
                            {
                                 $.pjax.reload({container:"#treepjax"});
                            }
                        })
                    }
                });
            }
        },
        items: {
            "create": {name: "{$add_option}", icon: "fa-plus"},
            "edit": {name: "{$update}", icon: "edit"},
            "delete": {name: "{$delete}", icon: "delete"}
        }
    });
});

JS;

$this->registerJs($js);

$url_new_question = Yii::$app->urlManager->createUrl('quiz/new-question?quiz_id=' . $model->id);

$script = <<< JS
$(document).on('click', '.quick-add-question', function () {       
    $('#addQuestionFormModel').modal('show').find('.modal-dialog').load('$url_new_question');
});

JS;
$this->registerJs($script);

?>

<?php if(!$has_questions): ?>

    <span  class="btn btn-success float-right ml-2 quick-add-question"><?= Yii::t('app', 'view.new_question') ?></span>

<?php endif; ?>

<div class="modal inmodal" id="addQuestionFormModel" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md "></div>
</div>

<div class="modal inmodal" id="addOptionFormModel" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md "></div>
</div>

<div class="chart w-100 h-100" id="quiz-question-node"></div>