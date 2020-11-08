<?php

namespace app\modules\user\models\forms;

use Yii;
use yii\base\Model;

class PasswordForm extends Model
{
    public $password;

    public $repete_password;

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
            [['password', 'repete_password'], "required"],
            [['password', 'repete_password'], 'string', 'max' => 200],
            [['password', 'repete_password'], 'string', 'min' => 6],
            ['repete_password', 'compare', 'compareAttribute' => 'password', 'message' => "Senhas não conferem"],
           
        ];
    }

    public function attributeLabels()
    {
        
        return
        [
            "password" => 'Senha',
            "repete_password" => 'Confirmação',
        ];
    }
    
    public function save($user)
    {
        if ($this->validate()) 
        {
            if($user)
            {
                $user->password = base64_encode($user->login . $this->password);
                $user->save(FALSE, ['password']);
                
                return true;
            }
        }
        
        return false;
    }
}