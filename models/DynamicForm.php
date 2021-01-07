<?php

namespace app\models;

use app\helpers\FormHelper;
use kartik\file\FileInput;
use kartik\money\MaskMoney;
use yii\helpers\ArrayHelper;
use yii\db\Exception;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;

class DynamicForm extends QuizQuestion
{
    public $id_form;

    public $id_option;

    private $_dynamicData = [];

    private $_dynamicFields = [];

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), self::getDynamicAttributeLabels());
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), self::getDynamicRules());
    }

    public function getFields()
    {
        if (! $this->id_form)
        {
            return [];
        }

        return FormQuestion::find()->where([
            'id_form' => $this->id_form,
            'is_active' => TRUE,
            'is_deleted' => FALSE
        ])
        ->orderBy('order ASC')
            ->all();
    }

    public function getDynamicRules()
    {
        $required = $safe = $rules = [];

        $required[] = 'id_option';

        foreach ($this->fields as $field)
        {
            if ($field->is_mandatory)
            {
                $required[] = 'dynamic_' . $field->id;
            }
            else
            {
                $safe[] = 'dynamic_' . $field->id;
            }
        }

        if (sizeof($required) > 0)
        {
            $rules[] =
                [
                    $required,
                    'required'
                ];
        }

        if (sizeof($safe) > 0)
        {
            $rules[] =
                [
                    $safe,
                    'safe'
                ];
        }

        return $rules;
    }

    public function getDynamicAttributeLabels()
    {
        $attributes =
        [
            'id_option' => $this->title
        ];

        foreach ($this->fields as $field)
        {
            $attributes = ArrayHelper::merge($attributes,
                [
                    'dynamic_' . $field->id => $field->name
                ]);
        }

        return $attributes;
    }

    public function __get($name)
    {
        if (! empty($this->_dynamicFields[$name]))
        {
            if (! empty($this->_dynamicData[$name]))
            {
                return $this->_dynamicData[$name];
            }
            else
            {
                return null;
            }
        }
        else
        {
            return parent::__get($name);
        }
    }

    public function __set($name, $value)
    {
        if (isset($this->_dynamicFields[$name]))
        {
            $this->_dynamicData[$name] = $value;
        }
        else
        {
            parent::__set($name, $value);
        }
    }

    public function getAttributesDynamicFields()
    {
        $this->_dynamicFields =
        [
            'id_option' => $this->id_option,
        ];

        foreach ($this->fields as $field)
        {
            $this->_dynamicFields = ArrayHelper::merge($this->_dynamicFields,
            [
                'dynamic_' . $field->id => $field->id
            ]);
        }

        return $this->_dynamicFields;
    }

    public function renderDynamicFields($form)
    {

        foreach ($this->attributesDynamicFields as $key => $field)
        {
            echo "<h3></h3><section>";

            if($key == 'id_option')
            {
                $options = QuizQuestionOption::find()->andWhere([
                    'is_active' => TRUE,
                    'is_deleted' => FALSE,
                    'id_question' => $this->id
                ])->orderBy('order ASC')->all();

                $items = ArrayHelper::map($options,'id', 'title');

                echo '<label class="control-label has-star">' . $this->getAttributeLabel($key) . '</label>';

                echo '<p>' . $this->description . '</p>';

                echo $form->field($this, $key)
                    ->radioList(
                        $items,
                        ['prompt' => '']
                    )->label(FALSE);

                echo '<hr>';
            }
            else
            {
                $field = FormQuestion::findOne($field);

                if($field->default)
                {
                    $this->{$key} = $field->default;
                }

                switch ($field->type)
                {
                    case FormHelper::CAMPO_DATE:

                        echo $form->field($this, $key)->widget(DatePicker::classname(), [
                            'language' => 'pt-BR',
                            'options' => ['autocomplete' => 'off','readOnly' => true, 'title' => $field->help],
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => ['autoclose' => true,'format' => 'dd/mm/yyyy'],
                        ])->label($this->getAttributeLabel($key));
                        break;

                    case FormHelper::CAMPO_TEXTAREA:

                        echo $form->field($this, $key)->textArea(['title' => $field->help])->label($this->getAttributeLabel($key));
                        break;

                    case FormHelper::CAMPO_CNPJ:

                        echo $form->field($this, $key)->widget(MaskedInput::className(), [
                            'mask' => '99.999.999/9999-99',
                            'options' => ['title' => $field->help],
                        ])->label($this->getAttributeLabel($key));
                        break;

                    case FormHelper::CAMPO_CPF:

                        echo $form->field($this, $key)->widget(MaskedInput::className(), [
                            'mask' => '999.999.999-99',
                            'options' => ['title' => $field->help],
                        ])->label($this->getAttributeLabel($key));
                        break;

                    case FormHelper::CAMPO_PHONE:

                        echo $form->field($this, $key)->widget(MaskedInput::className(), [
                            'mask' => '(99) 99999-9999',
                            'options' => ['title' => $field->help],
                        ])->label($this->getAttributeLabel($key));

                        break;

                    case FormHelper::CAMPO_CEP:

                        echo $form->field($this, $key)->widget(MaskedInput::className(), [
                            'mask' => '99999-999',
                            'options' => ['title' => $field->help],
                        ])->label($this->getAttributeLabel($key));

                        break;

                    case FormHelper::CAMPO_MONEY:

                        echo $form->field($this, $key)->widget(MaskMoney::classname(), [
                            'options' => ['title' => $field->help],
                            'pluginOptions' => [
                                'prefix' => 'R$ ',
                                'suffix' => '',
                                'allowNegative' => true,
                                'thousands' => '.',
                                'decimal' => ',',
                                'precision' => 2
                            ]
                        ])->label($this->getAttributeLabel($key));

                        break;

                    case FormHelper::CAMPO_VIEW:

                        $html = <<<HTML

                            <div class="form-group highlight-addon field-dynamicform-dynamic_{$field->id}">
                                <label class="control-label has-star" for="dynamicform-dynamic_{$field->id}">{$field->name}</label>
                                <p>{$field->default}</p>
                            </div>

HTML;

                        echo $html;
                        break;

                    case FormHelper::CAMPO_SIGN:

                        $html = <<<HTML

                            <div class="sigPad" id="field-dynamicform-dynamic_{$field->id}" style="width: 100%;">
                                <ul class="sigNav">
                                    <li class="clearButton"><a href="#clear">Clean</a></li>
                                </ul>
                                    <div class="sig sigWrapper" style="height:auto;">
                                    <div class="typed"></div>
                                    <canvas class="pad" width="800" height="250"></canvas>
                                    <input type="hidden" name="dynamicform-dynamic_{$field->id}" class="output">
                                </div>
                            </div>
                            
                            <script>
                                (function(window) {
                                    var _canvas,
                                    onResize = function(event) {
                                      _canvas.attr({
                                        width: $('#dynamic-form').innerWidth() - 40
                                      });
                                    };
                                
                                    $(document).ready(function() {
                                      _canvas = $('canvas');
                                      window.addEventListener('orientationchange', onResize, false);
                                      window.addEventListener('resize', onResize, false);
                                      onResize();
                                
                                      $('#field-dynamicform-dynamic_{$field->id}').signaturePad({
                                        drawOnly:true, 
                                        drawBezierCurves:true, 
                                        lineTop:200
                                      });
                                    });
                                  }(this));
                            </script>
                            

HTML;

                        echo $html;
                        break;

                    case FormHelper::CAMPO_IMAGE:

                        echo $form->field($this, $key)->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*', 'title' => $field->help],
                            'pluginOptions' => [
                                'showPreview' => false,
                                'browseClass' => 'btn btn-success',
                                'browseLabel' => 'Search',
                                'showUpload' => false,
                                'removeClass' => 'btn btn-success',
                                'removeLabel' => 'Delete'
                            ]
                        ])->label($this->getAttributeLabel($key));

                        break;

                    case FormHelper::CAMPO_IMAGE_MULTIPLE:

                        echo $form->field($this, $key)->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*', 'multiple' => true, 'title' => $field->help],
                            'pluginOptions' => [
                                'showPreview' => false,
                                'browseClass' => 'btn btn-success',
                                'browseLabel' => 'Search',
                                'showUpload' => false,
                                'removeClass' => 'btn btn-success',
                                'removeLabel' => 'Delete'
                            ]
                        ])->label($this->getAttributeLabel($key));

                        break;

                    case FormHelper::CAMPO_HOUR:

                        echo $form->field($this, $key)->textInput(['type' => 'time', 'title' => $field->help])->label($this->getAttributeLabel($key));
                        break;

                    case FormHelper::CAMPO_NUMBER:

                        echo $form->field($this, $key)->textInput(['type' => 'number', 'title' => $field->help])->label($this->getAttributeLabel($key));
                        break;

                    case FormHelper::CAMPO_TEXTFIELD:

                        if($field->size)
                        {
                            echo $form->field($this, $key)->textInput(['title' => $field->help, 'maxlength' => $field->size])->label($this->getAttributeLabel($key));
                        }
                        else
                        {
                            echo $form->field($this, $key)->textInput(['title' => $field->help])->label($this->getAttributeLabel($key));
                        }

                        break;

                    case FormHelper::CAMPO_CHECKBOX:

                        echo $form->field($this, $key)->checkbox(['title' => $field->help])->label($this->getAttributeLabel($key));
                        break;

                    case FormHelper::CAMPO_PASSWORD:

                        echo $form->field($this, $key)->passwordInput(['title' => $field->help])->label($this->getAttributeLabel($key));
                        break;

                    case FormHelper::CAMPO_RADIOLIST:

                        $items = ArrayHelper::map(FormQuestionOption::find()->andWhere([
                            'is_active' => TRUE,
                            'is_deleted' => FALSE,
                            'id_question' => $field->id
                        ])->orderBy('code ASC')->all(),'code', 'value');

                        echo $form->field($this, $key)
                            ->radioList(
                                $items,
                                ['title' => $field->help]
                            )->label($this->getAttributeLabel($key));

                        break;

                    case FormHelper::CAMPO_CHECKBOX_MULTIPLE:

                        $items = ArrayHelper::map(FormQuestionOption::find()->andWhere([
                            'is_active' => TRUE,
                            'is_deleted' => FALSE,
                            'id_question' => $field->id
                        ])->orderBy('code ASC')->all(),'code', 'value');

                        echo $form->field($this, $key)
                            ->checkboxList(
                                $items,
                                ['title' => $field->help]
                            )->label($this->getAttributeLabel($key));

                        break;

                    case FormHelper::CAMPO_SELECT:

                        $items = ArrayHelper::map(FormQuestionOption::find()->andWhere([
                            'is_active' => TRUE,
                            'is_deleted' => FALSE,
                            'id_question' => $field->id
                        ])->orderBy('code ASC')->all(),'code', 'value');

                        echo $form->field($this, $key)
                            ->dropDownList(
                                $items,
                                ['prompt' => '', 'title' => $field->help]
                            )->label($this->getAttributeLabel($key));

                        break;

                    case FormHelper::CAMPO_SELECT_MULTIPLE:

                        $items = ArrayHelper::map(FormQuestionOption::find()->andWhere([
                            'is_active' => TRUE,
                            'is_deleted' => FALSE,
                            'id_question' => $field->id
                        ])->orderBy('code ASC')->all(),'code', 'value');

                        echo $form->field($this, $key)
                            ->dropDownList(
                                $items,
                                ['multiple' => true, 'title' => $field->help]
                            )->label($this->getAttributeLabel($key));

                        break;

                    default:

                        echo $form->field($this, $key)->textInput(['title' => $field->help])->label($this->getAttributeLabel($key));
                }
            }

            echo "</section>";
        }
    }

//    public function save($runValidation = true, $attributeNames = null)
//    {
//        $transaction = \Yii::$app->db->beginTransaction();
//
//        try
//        {
//            if (! parent::save($runValidation = true, $attributeNames = null))
//            {
//                $transaction->rollback();
//                return false;
//            }
//
////            $this->saveDynamics();
//            $transaction->commit();
//
//        }
//        catch (Exception $e)
//        {
//            $transaction->rollback();
//        }
//
//        return true;
//    }

    public function saveDynamics($id_answer, $started_time, $id_option)
    {
        $quest_answ = AppQuizAnwser::find()->andWhere([
            'id_app_quiz' => $id_answer,
            'id_question' => $this->id,
        ])->one();

        if(!$quest_answ)
        {
            $quest_answ = new AppQuizAnwser();
            $quest_answ->id_app_quiz = $id_answer;
            $quest_answ->id_question = $this->id;
        }

        $quest_answ->id_option = $id_option;
        $quest_answ->ip = \Yii::$app->request->userIP;
        $quest_answ->started_at = date("Y-m-d H:i:s", $started_time);
        $quest_answ->finished_at = date('Y-m-d H:i:s', time());
        $quest_answ->save();

        foreach ($this->_dynamicFields as $field => $campo_id)
        {
            if (isset($this->_dynamicData[$field]) && $this->_dynamicData[$field] != '')
            {
                $value = $this->_dynamicData[$field];

                $answ = AppFormAnswer::find()->where([
                    'id_app_quiz_answer' => $quest_answ->id,
                    'id_form' => $this->id_form,
                    'id_question' => $campo_id,
                    'is_active' => TRUE,
                    'is_deleted' => FALSE
                ])->one();

                if ($answ)
                {
                    self::__set($field, $answ->answer);
                }
                else
                {
                    $answ = new AppFormAnswer();
                    $answ->id_app_quiz_answer = $quest_answ->id;
                    $answ->id_form = $this->id_form;
                    $answ->id_question = $campo_id;
                }

                $answ->answer = $value;

                if (! $answ->save())
                {
                    trigger_error($answ->getErrors());
                }
            }
        }

        return true;
    }
}