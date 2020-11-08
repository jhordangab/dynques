<?php

namespace app\modules\user\models\forms;

use Yii;
use yii\base\Model;
use app\models\UserM;

class EmailForm extends Model
{
    public $email;

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
            [["email"], "required"],
            ["email", "validateUser"],
        ];
    }

    public function attributeLabels()
    {
        
        return
        [
            "email" => 'Login',
        ];
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
    
    public function send()
    {
        if ($this->validate()) 
        {
            $user = $this->getUser();
            
            if($user && $user->validate())
            {
                return $user->sendPassword();
            }
        }
        
        return false;
    }
}