<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\UserM;
use app\models\UserToken;

class DefaultController extends Controller
{
    public $module;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'email', 'password'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => 
            [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }
 
        $model = $this->module->model("LoginForm");
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {
            $allowed_languages = ['ES' => 'es', 'EN' => 'en', 'PT' => 'pt-BR'];
            $selected_language = isset($allowed_languages[Yii::$app->user->identity->language]) ? $allowed_languages[Yii::$app->user->identity->language] : 'pt-BR';

            Yii::$app->language = $selected_language;
            Yii::$app->session->set('language', $selected_language);

            return $this->goBack();
        } 
        else 
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionEmail()
    {
        $this->layout = '//main-login';        
        
        if (!\Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }
 
        $model = $this->module->model("EmailForm");
        
        if ($model->load(Yii::$app->request->post()) && $model->send()) 
        {
            \Yii::$app->getSession()->setFlash('success','Senha enviado para o email com sucesso.');
            return $this->redirect(['/user/login']);
        } 
        else 
        {
            return $this->render('email', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionPassword($t)
    {
        $this->layout = '//main-login';        
        
        if (!\Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }
 
        $model = $this->module->model("PasswordForm");
        $token = $this->findToken($t);
        $usuario = ($token) ? UserM::findOne($token->id_user) : null;
        
        if ($model->load(Yii::$app->request->post()) && $model->save($usuario)) 
        {
            $token->is_used = TRUE;
            $token->save(FALSE, ['is_used']);
            
            \Yii::$app->getSession()->setFlash('success','Senha alterada com sucesso.');
            return $this->redirect(['/user/login']);
        } 
        else 
        {
            return $this->render('password', [
                'model' => $model,
                'usuario' => $usuario,
                'token' => $token
            ]);
        }
    }
    
    protected function findToken($t)
    {
        $model = UserToken::find()->andWhere([
            'token' => $t,
            'is_active' => TRUE,
            'is_deleted' => FALSE,
            'is_used' => FALSE
        ])->one();
                
        if($model)
        {
            $expirate_date = strtotime(date('Y-m-d',strtotime("-3 day")));
            $created_at = strtotime($model->created_at);

            if($created_at < $expirate_date)
            {
                $model = null;
            }
        }
        
        return $model;
    }
}