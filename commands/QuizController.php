<?php

namespace app\commands;

use app\models\Quiz;
use app\models\QuizQuestion;
use app\models\QuizQuestionOption;
use yii\console\Controller;

class QuizController extends Controller
{
    public function actionDuplicate($id_quiz)
    {
        $quiz = Quiz::findOne($id_quiz);
        $ques_array = [];

        if($quiz)
        {
            $n_quiz = new Quiz();
            $n_quiz->setAttributes($quiz->attributes);
            $n_quiz->name .= ' (copy)';
            $n_quiz->save();

            if($questions = $quiz->quizQuestions)
            {
                foreach($questions as $question)
                {
                    $n_question = new QuizQuestion();
                    $n_question->setAttributes($question->attributes);
                    $n_question->id_quiz = $n_quiz->id;
                    $n_question->save();

                    $ques_array[$question->id] = $n_question->id;
                }

                foreach($questions as $question)
                {
                    if($options = $question->options)
                    {
                        foreach ($options as $option)
                        {
                            $n_option = new QuizQuestionOption();
                            $n_option->setAttributes($option->attributes);
                            $n_option->id_question = $ques_array[$question->id];
                            if($option->id_next_question)
                            $n_option->id_next_question = $ques_array[$option->id_next_question];
                            $n_option->save();
                        }
                    }
                }
            }
        }
    }
}