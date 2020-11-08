<?php

namespace app\models;

use Yii;

class UserToken extends \yii\db\ActiveRecord
{
    public $updated_at;

    public static function tableName()
    {
        return 'dq_user_token';
    }

    public function rules()
    {
        return [
            [['id_user', 'token'], 'required'],
            [['id_user'], 'integer'],
            [['created_at', 'is_used', 'is_active', 'is_deleted'], 'safe'],
            [['token'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => UserM::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return
            [
                'id_user' => Yii::t('app', 'geral.user'),
                'token' => 'Token',
                'is_used' => Yii::t('app', 'geral.is_used'),
                'is_active' => Yii::t('app', 'geral.is_active'),
                'is_deleted' => Yii::t('app', 'geral.is_deleted'),
                'created_at' => Yii::t('app', 'geral.created_at'),
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

    public function getIdUserM()
    {
        return $this->hasOne(UserM::className(), ['id' => 'id_user']);
    }
}
