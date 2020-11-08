<?php

namespace app\modules\user\components;

use Yii;

class User extends \yii\web\User
{
    public $identityClass = 'app\modules\user\models\User';

    public $enableAutoLogin = true;

    public $loginUrl = ["/user/login"];

    public function getIsGuest()
    {
        $user = $this->getIdentity();

        return $user === null;
    }
    
    public function getIsLoggedIn()
    {
        return !$this->getIsGuest();
    }

    public function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);
    }
}
