<?php

namespace app\models;

use Yii;

class AppFormAnswer extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dq_app_form_answer';
    }

    public function rules()
    {
        return [
            [['id_app_quiz_answer', 'id_form', 'id_question'], 'required'],
            [['id_app_quiz_answer', 'id_form', 'id_question'], 'integer'],
            [['answer', 'created_at', 'updated_at'], 'safe'],
//            [['is_active', 'is_deleted'], 'string', 'max' => 1],
            [['id_app_quiz_answer'], 'exist', 'skipOnError' => true, 'targetClass' => AppQuizAnwser::className(), 'targetAttribute' => ['id_app_quiz_answer' => 'id']],
            [['id_form'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['id_form' => 'id']],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => FormQuestion::className(), 'targetAttribute' => ['id_question' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_app_quiz_answer' => 'Id App Quiz Answer',
            'id_form' => 'Id Form',
            'id_question' => 'Id Question',
            'answer' => 'Answer',
            'is_active' => Yii::t('app', 'geral.is_active'),
            'is_deleted' => Yii::t('app', 'geral.is_deleted'),
            'created_at' => Yii::t('app', 'geral.created_at'),
            'updated_at' => Yii::t('app', 'geral.updated_at'),
        ];
    }

    public function behaviors()
    {
        $behaviors =
            [
                [
                    'class' => \yii\behaviors\TimestampBehavior::className(),
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'value' => new \yii\db\Expression('NOW()'),
                ],
            ];

        return array_merge(parent::behaviors(), $behaviors);
    }

    public function getAppQuizAnswer()
    {
        return $this->hasOne(AppQuizAnwser::className(), ['id' => 'id_app_quiz_answer']);
    }

    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'id_form']);
    }

    public function getQuestion()
    {
        return $this->hasOne(FormQuestion::className(), ['id' => 'id_question']);
    }
}
