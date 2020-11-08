<?php

namespace app\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Area;

class AreaSearch extends Area
{
    public function rules()
    {
        return [
            [['id', 'id_user', 'order', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'is_active', 'is_deleted', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Area::find();

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

        if (!$this->validate())
        {
            return $dataProvider;
        }

        $user_id = Yii::$app->user->identity->id;

        $query->andFilterWhere([
            'id_user' => $user_id,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'is_deleted' => FALSE
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
