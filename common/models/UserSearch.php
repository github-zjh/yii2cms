<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'group_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        //转化前端yy-mm-dd的时间格式
        $transfer_before_created_at = $this->created_at;
        $transfer_before_updated_at = $this->updated_at;
        $this->created_at = $transfer_before_created_at ? strtotime($transfer_before_created_at) : '';
        $this->updated_at = $transfer_before_updated_at ? strtotime($transfer_before_updated_at) : '';

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'         => $this->id,
            'status'     => $this->status,
            'email'      => $this->email,
            'group_id'   => $this->group_id
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);

        if($this->created_at) {
            $created_at_start = $this->created_at;
            $created_at_end   = strtotime(date('Y-m-d 23:59:59', $this->created_at));
            $query->andFilterWhere(['between', 'created_at', $created_at_start, $created_at_end]);
        }

        if($this->updated_at) {
            $updated_at_start = $this->updated_at;
            $updated_at_end   = strtotime(date('Y-m-d 23:59:59', $this->updated_at));
            $query->andFilterWhere(['between', 'updated_at', $updated_at_start, $updated_at_end]);
        }

        //再转化过去前端需要显示的时间格式
        $this->created_at = $transfer_before_created_at;
        $this->updated_at = $transfer_before_updated_at;

        return $dataProvider;
    }
}
