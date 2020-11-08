<?php

namespace app\controllers;

use Yii;
use app\models\UserM;
use yii\filters\AccessControl;

class MyProfileController extends BaseController
{
    public function behaviors()
    {
        return
        [
            'access' => 
            [
                'class' => AccessControl::className(),
                'rules' => 
                [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }
    
    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity->id;
        $model = UserM::findOne($user_id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            $allowed_languages = ['ES' => 'es', 'EN' => 'en', 'PT' => 'pt-BR'];
            $selected_language = isset($allowed_languages[$model->language]) ? $allowed_languages[$model->language] : 'pt-BR';
            Yii::$app->language = $selected_language;
            Yii::$app->session->set('language', $selected_language);

            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.updated_message_o', [
                'model' => Yii::t('app', 'geral.profile')
            ]));

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
