<?php

namespace app\controllers;

use Yii;
use app\models\Area;
use app\models\searches\AreaSearch;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class AreaController extends BaseController
{
    public $hasFilter = TRUE;

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
                                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
                                    'allow' => true,
                                    'roles' => ['@'],
                                ],
                            ],
                    ]
            ];
    }

    public function actionIndex()
    {
        $searchModel = new AreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Area();
        $model->is_active = 1;
        $model->id_user = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.created_message_a', [
                'model' => Yii::t('app', 'geral.area')
            ]));

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.updated_message_a', [
                'model' => Yii::t('app', 'geral.area')
            ]));

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $status = !$model->is_deleted;
        $model->is_deleted = $status;

        if($model->save(FALSE, ['is_deleted']))
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.deleted_message_a', [
                'model' => Yii::t('app', 'geral.area')
            ]));
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $user_id = Yii::$app->user->identity->id;

        if (($model = Area::find()->andWhere(['id_user' => $user_id, 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'controller.mensagem_erro_404'));
    }
}
