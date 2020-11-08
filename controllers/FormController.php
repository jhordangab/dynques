<?php

namespace app\controllers;

use app\models\Form;
use app\models\searches\FormSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class FormController extends BaseController
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
        $searchModel = new FormSearch();
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
        $model = new Form();
        $model->is_active = 1;
        $model->id_user = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.created_message_o', [
                'model' => Yii::t('app', 'geral.form')
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
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.updated_message_o', [
                'model' => Yii::t('app', 'geral.form')
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
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.deleted_message_o', [
                'model' => Yii::t('app', 'geral.form')
            ]));
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $user_id = Yii::$app->user->identity->id;

        if (($model = Form::find()->andWhere(['id_user' => $user_id, 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'controller.mensagem_erro_404'));
    }
}
