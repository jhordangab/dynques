<?php

namespace app\models;

use Yii;

class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dq_category';
    }

    public function rules()
    {
        return [
            [['id_user', 'name'], 'required'],
            [['id_user', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'is_active', 'is_deleted'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [[], 'string', 'max' => 1],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => UserM::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_user' => Yii::t('app', 'geral.user'),
            'name' => Yii::t('app', 'geral.name'),
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

    public function getUserM()
    {
        return $this->hasOne(UserM::className(), ['id' => 'id_user']);
    }

    public function getQuizQuestions()
    {
        return $this->hasMany(QuizQuestion::className(), ['id_category' => 'id']);
    }

    public function getQuizQuestionOptions()
    {
        return $this->hasMany(QuizQuestionOption::className(), ['id_category' => 'id']);
    }
}
