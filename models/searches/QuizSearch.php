<?php

namespace app\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quiz;

class QuizSearch extends Quiz
{
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_area', 'order', 'created_by', 'updated_by'], 'integer'],
            [['name', 'is_active', 'is_deleted', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Quiz::find()->joinWith('area');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>
                [
                    'defaultOrder' =>
                        [
                            'id_area' => SORT_ASC,
                            'order' => SORT_ASC
                        ]
                ]
        ]);

        $dataProvider->sort->attributes['id_area'] = [
            'asc' => ['dq_area.name' => SORT_ASC],
            'desc' => ['dq_area.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate())
        {
            return $dataProvider;
        }

        $user_id = Yii::$app->user->id;

        $query->andFilterWhere([
            'dq_quiz.order' => $user_id,
            'dq_quiz.order' => $this->order,
            'dq_quiz.id_area' => $this->id_area,
            'dq_quiz.is_active' => $this->is_active,
            'dq_quiz.is_deleted' => FALSE,
        ]);

        $query->andFilterWhere(['like', 'dq_quiz.name', $this->name])
            ->andFilterWhere(['like', 'dq_quiz.description', $this->description]);

        return $dataProvider;
    }
}
