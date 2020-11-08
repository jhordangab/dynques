<?php

namespace app\models;

use Yii;

class AppQuizAnwser extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dq_app_quiz_answer';
    }

    public function rules()
    {
        return [
            [['id_app_quiz', 'id_question', 'id_option'], 'required'],
            [['id_app_quiz', 'id_question', 'id_option', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'is_active', 'is_deleted'], 'safe'],
            [['id_app_quiz'], 'exist', 'skipOnError' => true, 'targetClass' => AppQuiz::className(), 'targetAttribute' => ['id_app_quiz' => 'id']],
            [['id_option'], 'exist', 'skipOnError' => true, 'targetClass' => QuizQuestionOption::className(), 'targetAttribute' => ['id_option' => 'id']],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => QuizQuestion::className(), 'targetAttribute' => ['id_question' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_app_quiz' => Yii::t('app', 'geral.quiz'),
            'id_question' => Yii::t('app', 'geral.question'),
            'id_option' => Yii::t('app', 'geral.option'),
            'is_active' => Yii::t('app', 'geral.is_active'),
            'is_deleted' => Yii::t('app', 'geral.is_deleted'),
            'created_at' => Yii::t('app', 'geral.created_at'),
            'updated_at' => Yii::t('app', 'geral.updated_at'),
            'created_by' => Yii::t('app', 'geral.created_by'),
            'updated_by' => Yii::t('app', 'geral.updated_by')
        ];
    }

    public function behaviors()
    {
        $behaviors =
            [
                [
                    'class' => \yii\behaviors\BlameableBehavior::className(),
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
                [
                    'class' => \yii\behaviors\TimestampBehavior::className(),
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'value' => new \yii\db\Expression('NOW()'),
                ],
            ];

        return array_merge(parent::behaviors(), $behaviors);
    }

    public function getAppFormAnswers()
    {
        return $this->hasMany(AppFormAnswer::className(), ['id_app_quiz_answer' => 'id']);
    }

    public function getAppQuiz()
    {
        return $this->hasOne(AppQuiz::className(), ['id' => 'id_app_quiz']);
    }

    public function getOption()
    {
        return $this->hasOne(QuizQuestionOption::className(), ['id' => 'id_option']);
    }

    public function getQuestion()
    {
        return $this->hasOne(QuizQuestion::className(), ['id' => 'id_question']);
    }
}
