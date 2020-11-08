<?php

namespace app\controllers;

use app\models\QuizQuestionOption;
use app\models\DynamicForm;
use Yii;
use app\models\Quiz;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\QuizQuestion;

class AppController extends BaseController
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
                                    'actions' => ['main', 'render-form', 'success'],
                                    'allow' => true,
                                ],
                            ],
                    ]
            ];
    }

    public function actionMain($id, $question_id = null)
    {
        $this->layout = 'app';

        $allowed_languages = ['ES' => 'es', 'EN' => 'en', 'PT' => 'pt-BR'];

        $model = $this->findModel($id);
        $selected_language = isset($allowed_languages[$model->user->language]) ? $allowed_languages[$model->user->language] : 'pt-BR';
        Yii::$app->language = $selected_language;
        Yii::$app->session->set('language', $selected_language);

        if(!$question_id)
        {
            $question = QuizQuestion::find()->andWhere([
                'order' => 1,
                'is_active' => TRUE,
                'is_deleted' => FALSE,
                'id_quiz' => $id
            ])->one();
        }
        else
        {
            $question = QuizQuestion::findOne($question_id);
        }

        $options = QuizQuestionOption::find()->andWhere([
            'is_active' => TRUE,
            'is_deleted' => FALSE,
            'id_question' => $question->id
        ])->orderBy('order ASC')->all();

        $dynamic = DynamicForm::findOne($question->id);

        if(sizeof($options) == 1)
        {
            $dynamic->id_option = $options[0]->id;
            $dynamic->id_form = $options[0]->id_form;
        }

        $dynamic->getAttributesDynamicFields();

        if ($dynamic->load(Yii::$app->request->post()) && $dynamic->validate())
        {
            $selected_option = QuizQuestionOption::findOne($dynamic->id_option);
            $dynamic->id_form = $selected_option->id_form;

            if ($selected_option->id_next_question) {
                return $this->redirect(['main', 'id' => $id, 'pergunta_id' => $selected_option->id_next_question]);
            } else {
                return $this->redirect(['success', 'id' => $model->id]);
            }
        }

        return $this->render('main', [
            'model' => $model,
            'dynamic' => $dynamic
        ]);
    }

    public function actionSuccess($id)
    {
        $this->layout = 'app';

        $model = $this->findModel($id);

        return $this->render('success', [
            'model' => $model,
        ]);
    }

    public function actionRenderForm($id, $question_id, $option_id)
    {
        $model = $this->findModel($id);
        $selected_option = QuizQuestionOption::findOne($option_id);

        $dynamic = DynamicForm::findOne($question_id);
        $dynamic->id_option = $selected_option->id;
        $dynamic->id_form = $selected_option->id_form;
        $dynamic->getAttributesDynamicFields();

        return $this->renderAjax( '_form', [
            'model' => $model,
            'dynamic' => $dynamic
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Quiz::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'controller.mensagem_erro_404'));
    }
}
