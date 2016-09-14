<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Category;

/**
 * CategorySearch represents the model behind the search form about `common\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'parent_id', 'user_id'], 'safe'],
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
        $query = Category::find();

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
            'sort'       => $this->sort,
            'status'     => $this->status
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        //按照父级分类查询
        if(!empty($this->parent_id)) {
            $category = Category::find()->andFilterCompare('name', $this->parent_id, 'like')->one();
            if($category) {
                $query->andFilterWhere(['parent_id' => $category->id]);
            } else {
                $query->andFilterWhere(['parent_id' => -1]);
            }
        }

        //按照作者用户名查询
        if(!empty($this->user_id)) {
            $user = User::find()->andFilterCompare('username', $this->user_id, 'like')->one();
            if($user) {
                $query->andFilterWhere(['user_id' => $user->id]);
            } else {
                $query->andFilterWhere(['user_id' => -1]);
            }
        }
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
