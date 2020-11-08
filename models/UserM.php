<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class UserM extends ActiveRecord implements IdentityInterface
{
    public $version;

    public $module;

    public $repete_password;

    public $new_password;

    public $repete_new_password;

    public static function tableName()
    {
        return 'dq_user';
    }

    public function rules()
    {
        return [
            [['name', 'login', 'email', 'password'], 'required'],
            [['password', 'repete_password'], 'required', 'on' => 'create'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'is_active', 'is_deleted'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['language', 'name', 'login', 'email', 'password', 'cell', 'logo'], 'string', 'max' => 255],
            [['password', 'new_password', 'repete_password', 'repete_new_password'], 'string', 'max' => 200],
            [['password', 'new_password', 'repete_password', 'repete_new_password'], 'string', 'min' => 6],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['login'], 'unique'],
            ['repete_password', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "Senhas não conferem", 'on' => 'create'],
            ['repete_new_password', 'compare', 'compareAttribute' => 'new_password', 'skipOnEmpty' => true, 'message' => "Senhas não conferem", 'on' => 'update'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'geral.name'),
            'login' => Yii::t('app', 'geral.login'),
            'email' => Yii::t('app', 'geral.email'),
            'language' => Yii::t('app', 'geral.language'),
            'cell' => Yii::t('app', 'geral.cell'),
            'password' => Yii::t('app', 'geral.password'),
            'new_password' => Yii::t('app', 'geral.new_password'),
            'repete_password' => Yii::t('app', 'geral.repete_password'),
            'repete_new_password' => Yii::t('app', 'geral.repete_new_password'),
            'description' => Yii::t('app', 'geral.is_active'),
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

    public function getAuthKey(): string {
        return '';
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey): bool {
        return true;
    }

    public static function findIdentity($id): IdentityInterface
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): IdentityInterface {

    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->password = base64_encode($this->login . $this->password);
        }
        else
        {
            if($this->new_password && $this->repete_new_password)
            {
                $this->password = base64_encode($this->login . $this->new_password);
            }
        }

        return parent::beforeSave($insert);
    }

    public function sendPassword()
    {
        $token = Yii::$app->security->generateRandomString() . time();

        $modelToken = new UserToken();
        $modelToken->id_user = $this->id;
        $modelToken->token = $token;
        $modelToken->save();

        \Yii::$app->mailer->htmlLayout = "@app/mail/layouts/html";

        $url = Yii::$app->request->hostInfo . "/user/password?t={$token}";

        $message = \Yii::$app->mailer->compose (['html' => '@app/mail/views/change-password'] ,['name' => $this->name, 'url' => $url]);
        $message->setFrom('bp1@bpone.com.br');
        $message->setTo($this->email);
        $message->setSubject("Dynques - Password");
        $sent = $message->send();

        return $sent;
    }

    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['id_user' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id_user' => 'id']);
    }

    public function getForms()
    {
        return $this->hasMany(Form::className(), ['id_user' => 'id']);
    }

    public function getQuiz()
    {
        return $this->hasMany(Quiz::className(), ['id_user' => 'id']);
    }

    public function getUserMTokens()
    {
        return $this->hasMany(UserToken::className(), ['id_user' => 'id']);
    }
}
