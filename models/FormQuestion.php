<?php

namespace app\models;

use Yii;

class FormQuestion extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dq_form_question';
    }

    public function rules()
    {
        return [
            [['id_form', 'order', 'name', 'type'], 'required'],
            [['id_form', 'order', 'size', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'is_mandatory', 'is_active', 'is_deleted'], 'safe'],
            [['name', 'type', 'help', 'default'], 'string', 'max' => 255],
            [['id_form'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['id_form' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_form' => Yii::t('app', 'geral.form'),
            'order' => Yii::t('app', 'geral.order'),
            'name' => Yii::t('app', 'geral.name'),
            'type' => Yii::t('app', 'geral.type'),
            'help' => Yii::t('app', 'geral.help'),
            'default' => Yii::t('app', 'geral.default'),
            'size' => Yii::t('app', 'geral.size'),
            'is_mandatory' => Yii::t('app', 'geral.is_mandatory'),
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
        return $this->hasMany(AppFormAnswer::className(), ['id_question' => 'id']);
    }

    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'id_form']);
    }

    public function getFormQuestionOptions()
    {
        return $this->hasMany(FormQuestionOption::className(), ['id_question' => 'id']);
    }
}
