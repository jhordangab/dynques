<?php

namespace app\models;

use Yii;

class QuizQuestion extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dq_quiz_question';
    }

    public function rules()
    {
        return [
            [['id_quiz', 'order', 'title'], 'required'],
            [['id_quiz', 'id_category', 'order', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'is_active', 'is_deleted'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['id_category' => 'id']],
            [['id_quiz'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['id_quiz' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_quiz' => Yii::t('app', 'geral.quiz'),
            'id_category' => Yii::t('app', 'geral.category'),
            'order' => Yii::t('app', 'geral.order'),
            'title' => Yii::t('app', 'geral.title'),
            'description' => Yii::t('app', 'geral.description'),
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
        return $this->hasMany(AppQuizAnwser::className(), ['id_question' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'id_category']);
    }

    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'id_quiz']);
    }

    public function getQuisQuestionOptions()
    {
        return $this->hasMany(QuizQuestionOption::className(), ['id_question' => 'id']);
    }

    public function getQuisQuestionOptions0()
    {
        return $this->hasMany(QuizQuestionOption::className(), ['id_next_question' => 'id']);
    }
}
