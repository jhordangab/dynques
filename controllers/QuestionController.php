<?php

namespace app\controllers;

use app\models\Form;
use app\models\FormQuestion;
use app\models\FormQuestionOption;
use yii\base\Model;
use yii\helpers\Json;
use Yii;
use app\models\searches\FormQuestionSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

class QuestionController extends BaseController
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
                                    'actions' => ['index', 'view', 'create', 'update', 'delete', 'new-option', 'validate-option', 'delete-option'],
                                    'allow' => true,
                                    'roles' => ['@'],
                                ],
                            ],
                    ]
            ];
    }

    public function actionIndex($id_form)
    {
        $user_id = Yii::$app->user->identity->id;

        if (($form = Form::find()->andWhere(['id_user' => $user_id, 'id' => $id_form])->one()) == null) {
            throw new NotFoundHttpException(\Yii::t('app', 'controller.mensagem_erro_404'));
        }

        $searchModel = new FormQuestionSearch();
        $dataProvider = $searchModel->search($id_form, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'form' => $form,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($id_form)
    {
        $model = new FormQuestion();
        $model->id_form = $id_form;
        $model->is_active = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.created_message_a', [
                'model' => Yii::t('app', 'geral.question')
            ]));

            return $this->redirect(['index', 'id_form' => $id_form]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $query = FormQuestionOption::find()->andWhere([
            'is_active' => true,
            'is_deleted' => false,
            'id_question' => $model->id
        ])->indexBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.updated_message_a', [
                'model' => Yii::t('app', 'geral.question')
            ]));

            return $this->redirect(['index', 'id_form' => $model->id_form]);
        }

        $options = $query->all();

        if (Model::loadMultiple($options, Yii::$app->request->post()) && Model::validateMultiple($options)) {
            foreach ($options as $option) {
                $option->save(false);
                \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.updated_message_a', [
                    'model' => Yii::t('app', 'geral.option')
                ]));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionValidateOption() {
        $model = new FormQuestionOption();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionNewOption($question_id)
    {
        $model = new FormQuestionOption();
        $model->id_question = $question_id;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->validate()) {
                    $flag = $model->save(false);
                    if ($flag == true) {
                        $transaction->commit();
                        return Json::encode(array('status' => 'success', 'type' => 'success', 'message' => Yii::t('app', 'controller.created_message_a', [
                            'model' => Yii::t('app', 'geral.option')
                        ])));
                    } else {
                        $transaction->rollBack();
                    }
                } else {
                    return Json::encode(array('status' => 'error', 'type' => 'error', 'message' => $model->getErrors()));
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }

        return $this->renderAjax('_partial/_create_option', [
            'model' => $model,
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
                'model' => Yii::t('app', 'geral.question')
            ]));
        }

        return $this->redirect(['index', 'id_form' => $model->id_form]);
    }

    public function actionDeleteOption($id)
    {
        $model = FormQuestionOption::findOne($id);
        $status = !$model->is_deleted;
        $model->is_deleted = $status;

        if($model->save(FALSE, ['is_deleted']))
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.deleted_message_a', [
                'model' => Yii::t('app', 'geral.option')
            ]));
        }

        return true;
    }

    protected function findModel($id)
    {
        $model = FormQuestion::findOne($id);
        $user_id = Yii::$app->user->id;

        if ($model !== null && $model->form->id_user == $user_id) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'controller.mensagem_erro_404'));
    }
}
