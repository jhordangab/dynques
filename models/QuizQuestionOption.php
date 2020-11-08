<?php

namespace app\models;

use Yii;

class QuizQuestionOption extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dq_quiz_question_option';
    }

    public function rules()
    {
        return [
            [['id_question', 'order', 'title'], 'required'],
            [['id_question', 'id_form', 'id_category', 'order', 'id_next_question', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'is_active', 'is_deleted'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['id_category' => 'id']],
            [['id_form'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['id_form' => 'id']],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => QuizQuestion::className(), 'targetAttribute' => ['id_question' => 'id']],
            [['id_next_question'], 'exist', 'skipOnError' => true, 'targetClass' => QuizQuestion::className(), 'targetAttribute' => ['id_next_question' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_question' => Yii::t('app', 'geral.question'),
            'id_form' => Yii::t('app', 'geral.form'),
            'id_category' => Yii::t('app', 'geral.category'),
            'order' => Yii::t('app', 'geral.order'),
            'title' => Yii::t('app', 'geral.title'),
            'description' => Yii::t('app', 'geral.description'),
            'id_next_question' => Yii::t('app', 'geral.next_question'),
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

    public function getAppQuizAnswers()
    {
        return $this->hasMany(AppQuizAnwser::className(), ['id_option' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'id_category']);
    }

    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'id_form']);
    }

    public function getQuestion()
    {
        return $this->hasOne(QuizQuestion::className(), ['id' => 'id_question']);
    }

    public function getNextQuestion()
    {
        return $this->hasOne(QuizQuestion::className(), ['id' => 'id_next_question']);
    }
}
