<?php

namespace app\controllers;

use app\magic\TreeMagic;
use app\models\QuizQuestionOption;
use Yii;
use app\models\searches\QuizSearch;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\QuizQuestion;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use app\models\Quiz;

class QuizController extends BaseController
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
                                    'actions' => ['index', 'question', 'view', 'create', 'update', 'delete', 'new-question', 'update-question', 'delete-question', 'question-validate',
                                        'new-option', 'update-option', 'delete-option', 'option-validate'],
                                    'allow' => true,
                                    'roles' => ['@'],
                                ],
                            ],
                    ]
            ];
    }

    public function actionIndex()
    {
        $searchModel = new QuizSearch();
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

    public function actionQuestion($id)
    {
        $model = $this->findModel($id);

        $nodes = TreeMagic::getTree($id);

        $has_questions = QuizQuestion::find()->andWhere([
            'order' => 1,
            'is_active' => TRUE,
            'is_deleted' => FALSE,
            'id_quiz' => $id
        ])->exists();

        return $this->render('question', [
            'model' => $model,
            'nodes' => $nodes,
            'has_questions' => $has_questions
        ]);
    }

    public function actionCreate()
    {
        $model = new Quiz();
        $model->is_active = 1;
        $model->id_user = Yii::$app->user->identity->id;
        
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.created_message_o', [
                'model' => Yii::t('app', 'geral.quiz')
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
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.created_message_o', [
                'model' => Yii::t('app', 'geral.quiz')
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
                'model' => Yii::t('app', 'geral.quiz')
            ]));
        }

        return $this->redirect(['index']);
    }

    public function actionNewQuestion($quiz_id, $option_id = null)
    {
        $model = new QuizQuestion();
        $model->id_quiz = $quiz_id;
        $model->order = (!$option_id) ? 1 : 2;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->validate()) {
                    $flag = $model->save(false);
                    if ($flag == true) {
                        $transaction->commit();
                        if($option_id)
                        {
                            $option = QuizQuestionOption::findOne($option_id);
                            if($option)
                            {
                                $option->id_next_question = $model->id;
                                $option->save(FALSE, ['id_next_question']);
                            }
                        }

                        return Json::encode(array('status' => 'success', 'type' => 'success', 'message' =>
                            Yii::t('app', 'controller.created_message_a', [
                                'model' => Yii::t('app', 'geral.question')
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

        return $this->renderAjax('_partial/_create_question', [
            'model' => $model,
        ]);
    }

    public function actionUpdateQuestion($id)
    {
        $model = QuizQuestion::findOne($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->validate()) {
                    $flag = $model->save(false);
                    if ($flag == true) {
                        $transaction->commit();
                        return Json::encode(array('status' => 'success', 'type' => 'success', 'message' =>
                            Yii::t('app', 'controller.updated_message_a', [
                                'model' => Yii::t('app', 'geral.question')
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

        return $this->renderAjax('_partial/_create_question', [
            'model' => $model,
        ]);

    }

    public function actionDeleteQuestion($id)
    {
        $model = QuizQuestion::findOne($id);
        $status = !$model->is_deleted;
        $model->is_deleted = $status;

        if($model->save(FALSE, ['is_deleted']))
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.deleted_message_a', [
                'model' => Yii::t('app', 'geral.question')
            ]));
        }
    }

    public function actionQuestionValidate() {
        $model = new QuizQuestion();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionNewOption($question_id)
    {
        $model = new QuizQuestionOption();
        $model->id_question = $question_id;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->validate()) {
                    $flag = $model->save(false);
                    if ($flag == true) {
                        $transaction->commit();
                        return Json::encode(array('status' => 'success', 'type' => 'success', 'message' =>
                            Yii::t('app', 'controller.created_message_a', [
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

    public function actionUpdateOption($id)
    {
        $model = QuizQuestionOption::findOne($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->validate()) {
                    $flag = $model->save(false);
                    if ($flag == true) {
                        $transaction->commit();
                        return Json::encode(array('status' => 'success', 'type' => 'success', 'message' =>
                            Yii::t('app', 'controller.updated_message_a', [
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

    public function actionDeleteOption($id)
    {
        $model = QuizQuestionOption::findOne($id);
        $status = !$model->is_deleted;
        $model->is_deleted = $status;

        if($model->save(FALSE, ['is_deleted']))
        {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'controller.deleted_message_a', [
                'model' => Yii::t('app', 'geral.option')
            ]));
        }
    }

    public function actionOptionValidate() {
        $model = new QuizQuestionOption();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    protected function findModel($id)
    {
        $user_id = Yii::$app->user->identity->id;

        if (($model = Quiz::find()->andWhere(['id_user' => $user_id, 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'controller.mensagem_erro_404'));
    }
}
