<?php

namespace app\controllers;

use app\models\Area;
use Yii;
use app\models\Quiz;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class MyQuizController extends BaseController
{
    public $hasFilter = FALSE;

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
                                    'roles' => ['@'],
                                ],
                            ],
                    ]
            ];
    }

    public function actionIndex($id)
    {
        $area = Area::findOne($id);

        $user_id = Yii::$app->user->id;

        if($area->id_user != $user_id)
        {
            throw new NotFoundHttpException(\Yii::t('app', 'controller.mensagem_erro_404'));
        }

        $models = Quiz::find()->andWhere([
            'id_area' => $id,
            'id_user' => $user_id,
            'is_active' => TRUE,
            'is_deleted' => FALSE
        ])->orderBy('order ASC')->all();

        return $this->render('index', [
            'area' => $area,
            'quizz' => $models
        ]);
    }
}
