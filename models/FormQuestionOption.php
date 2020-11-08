<?php

namespace app\models;

use Yii;

class FormQuestionOption extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dq_form_question_option';
    }

    public function rules()
    {
        return [
            [['id_question', 'code', 'value'], 'required'],
            [['id_question', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'is_active', 'is_deleted'], 'safe'],
            [['code', 'value'], 'string', 'max' => 255],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => FormQuestion::className(), 'targetAttribute' => ['id_question' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_question' => Yii::t('app', 'geral.question'),
            'code' => Yii::t('app', 'geral.code'),
            'value' => Yii::t('app', 'geral.value'),
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

    public function getQuestion()
    {
        return $this->hasOne(FormQuestion::className(), ['id' => 'id_question']);
    }
}
