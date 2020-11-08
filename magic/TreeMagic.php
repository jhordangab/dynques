<?php

namespace app\magic;

use app\models\QuizQuestion;
use app\models\QuizQuestionOption;
use Yii;

class TreeMagic
{
    public static function getTree($id_quiz)
    {
        $questions = QuizQuestion::find()->andWhere([
            'order' => 1,
            'is_active' => TRUE,
            'is_deleted' => FALSE,
            'id_quiz' => $id_quiz
        ])->limit(1)->all();

        return self::getContent($questions);
    }

    public static function getContent($questions)
    {
        $menu = [];

        foreach($questions as $question)
        {
            $options = QuizQuestionOption::find()->andWhere([
                'is_active' => TRUE,
                'is_deleted' => FALSE,
                'id_question' => $question->id
            ])->orderBy('order ASC')->all();

            $children = [];

            if($options) {
                foreach ($options as $option) {
                    if ($option->id_next_question) {
                        $next_questions = QuizQuestion::find()->andWhere([
                            'is_active' => TRUE,
                            'is_deleted' => FALSE,
                            'id' => $option->id_next_question
                        ])->all();

                        $children[] = [
                            'text' => [
                                'name' => $option->title,
                                'data-type' => 'option',
                                'data-id' => $option->id,
                                'data-questionid' => $question->id,
                                'data-quizid' => $question->id_quiz,
                                'data-next' => sizeof($next_questions) > 0
                            ],
                            'HTMLclass' => (sizeof($next_questions) > 0) ? 'option with-children' : 'option with-no-children' ,
                            'connectors' =>
                                [
                                    'style' => [
                                        'stroke' => '#1761a0'
                                    ]
                                ],
                            'children' => (sizeof($next_questions) > 0) ? [self::getContent($next_questions)] : null
                        ];
                    } else {
                        $children[] = [
                            'text' => [
                                'name' => $option->title,
                                'data-type' => 'option',
                                'data-id' => $option->id,
                                'data-questionid' => $question->id,
                                'data-quizid' => $question->id_quiz,
                                'data-next' => false
                            ],
                            'HTMLclass' => 'option with-no-children',
                            'connectors' =>
                                [
                                    'style' => [
                                        'stroke' => '#1761a0'
                                    ]
                                ],
                        ];
                    }
                }
            }

            $menu = [
                'text' => [
                    'name' => $question->title,
                    'data-type' => 'question',
                    'data-id' => $question->id,
                    'data-quizid' => $question->id_quiz
                ],
                'HTMLclass' => 'question',
                'connectors' =>
                [
                    'style' => [
                        'stroke' => '#f5ce2f',
                        'arrow-end' => 'block-wide-long'
                    ]
                ],
                'children' => $children
            ];
        }

        return $menu;
    }
}
