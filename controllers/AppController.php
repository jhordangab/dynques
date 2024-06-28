<?php

namespace app\controllers;

use app\models\AppQuiz;
use app\models\AppQuizAnwser;
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

    public function actionMain($id_quiz, $id_answer = null, $question_id = null, $t = 0)
    {
        $this->layout = 'app';

        $allowed_languages = ['ES' => 'es', 'EN' => 'en', 'PT' => 'pt-BR'];

        $model = $this->findModel($id_quiz);

        if($t == 0)
        {
            $t = strtotime('now');
        }

        if(!$id_answer)
        {
            $answer = new AppQuiz();
            $answer->id_quiz = $id_quiz;
            $answer->save();

            return $this->redirect(['main', 'id_quiz' => $id_quiz, 'id_answer' => $answer->id, 'question_id' => $question_id]);
        }

        $selected_language = isset($allowed_languages[$model->user->language]) ? $allowed_languages[$model->user->language] : 'pt-BR';
        Yii::$app->language = $selected_language;
        Yii::$app->session->set('language', $selected_language);

        if(!$question_id)
        {
            $question = QuizQuestion::find()->andWhere([
                'order' => 1,
                'is_active' => TRUE,
                'is_deleted' => FALSE,
                'id_quiz' => $id_quiz
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

        $post = Yii::$app->request->post();

        if(sizeof($options) == 1)
        {
            $dynamic->id_option = $options[0]->id;
            $dynamic->id_form = $options[0]->id_form;
        }
        elseif(isset($post["DynamicForm"]['id_option']))
        {
            $selected_option = QuizQuestionOption::findOne($post["DynamicForm"]['id_option']);
            $dynamic->id_option = $selected_option->id;
            $dynamic->id_form = $selected_option->id_form;
        }

        $dynamic->getAttributesDynamicFields();

        if ($dynamic->load($post) && $dynamic->validate())
        {
            $selected_option = QuizQuestionOption::findOne($dynamic->id_option);
            $dynamic->id_form = $selected_option->id_form;
            $dynamic->saveDynamics($id_answer, $t, $dynamic->id_option);

            if ($selected_option->id_next_question) {
                return $this->redirect(['main', 'id_quiz' => $id_quiz, 'id_answer' => $id_answer, 'question_id' => $selected_option->id_next_question]);
            } else {
                return $this->redirect(['success', 'id_quiz' => $model->id, 'id_answer' => $id_answer]);
            }
        }

        return $this->render('main', [
            'model' => $model,
            'id_answer' => $id_answer,
            't' => $t,
            'dynamic' => $dynamic
        ]);
    }

    public function actionSuccess($id_quiz, $id_answer)
    {
        $this->layout = 'app';

        $model = $this->findModel($id_quiz);

        if(isset(Yii::$app->params['quizComercial']) && Yii::$app->params['quizComercial'] == $id_quiz) {
            $sql = <<<SQL
select
	dqq.`order` as formulario_ordem,
	dqq.title as formulario,
	dfq.`order` as pergunta_ordem,
	dfq.name,
	dafa.answer as resposta
from
	dq_app_quiz_answer asw
join dq_quiz_question dqq on
	dqq.id = asw.id_question
	and dqq.is_active = 1
	and dqq.is_deleted = 0
join dq_app_form_answer dafa on
	dafa.id_app_quiz_answer = asw.id
	and dafa.is_active = 1
	and dafa.is_deleted = 0
join dq_form_question dfq on
	dfq.id = dafa.id_question
	and dfq.is_active = 1
	and dfq.is_deleted = 0
where
	asw.is_active = 1
	and asw.is_deleted = 0
	and asw.id_app_quiz = {$id_answer}
order by
	dqq.`order` asc,
    dfq.`order` asc
SQL;

            $result = Yii::$app->db->createCommand($sql)->queryAll();

            $data = [];

            foreach($result as $r) {
                $data[$r['formulario_ordem']][$r['pergunta_ordem']] = $r['resposta'];
            }

            return $this->render('success_comercial', [
                'model' => $model,
                'data' => $data
            ]);
        } else {
            return $this->render('success', [
                'model' => $model,
            ]);
        }
    }

    public function actionRenderForm($id_quiz, $id_answer, $question_id, $option_id, $t)
    {
        $model = $this->findModel($id_quiz);
        $selected_option = QuizQuestionOption::findOne($option_id);

        $dynamic = DynamicForm::findOne($question_id);
        $dynamic->id_option = $selected_option->id;
        $dynamic->id_form = $selected_option->id_form;
        $dynamic->getAttributesDynamicFields();

        return $this->renderAjax( '_form', [
            'model' => $model,
            'id_answer' => $id_answer,
            't' => $t,
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
