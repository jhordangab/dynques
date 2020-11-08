<?php

namespace app\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FormQuestion;

class FormQuestionSearch extends FormQuestion
{
    public function rules()
    {
        return [
            [['id', 'id_form', 'order', 'size', 'created_by', 'updated_by'], 'integer'],
            [['name', 'type', 'help', 'default', 'is_mandatory', 'is_active', 'is_deleted', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($id_form, $params)
    {
        $query = FormQuestion::find()->joinWith('form');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>
                [
                    'defaultOrder' =>
                        [
                            'order' => SORT_ASC
                        ]
                ]
        ]);

        $this->load($params);

        $query->andWhere(['dq_form_question.id_form' => $id_form]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $id_user = Yii::$app->user->id;

        $query->andFilterWhere([
            'dq_form.id_user' => $id_user,
            'dq_form_question.order' => $this->order,
            'dq_form_question.size' => $this->size,
            'dq_form_question.is_mandatory' => $this->is_mandatory,
            'dq_form_question.is_active' => $this->is_active,
            'dq_form_question.is_deleted' => FALSE
        ]);

        $query->andFilterWhere(['like', 'dq_form_question.name', $this->name])
            ->andFilterWhere(['like', 'dq_form_question.type', $this->type])
            ->andFilterWhere(['like', 'dq_form_question.help', $this->help])
            ->andFilterWhere(['like', 'dq_form_question.default', $this->default]);

        return $dataProvider;
    }
}
