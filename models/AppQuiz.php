<?php

namespace app\models;

use Yii;

class AppQuiz extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dq_app_quiz';
    }

    public function rules()
    {
        return [
            [['id_quiz'], 'required'],
            [['id_quiz'], 'integer'],
            [['created_at', 'updated_at', 'is_active', 'is_deleted'], 'safe'],
            [['id_quiz'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['id_quiz' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_quiz' => Yii::t('app', 'geral.quiz'),
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

    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'id_quiz']);
    }

    public function getAppQuizAnswers()
    {
        return $this->hasMany(AppQuizAnwser::className(), ['id_app_quiz' => 'id']);
    }
}
