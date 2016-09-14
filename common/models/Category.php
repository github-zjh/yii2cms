<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $user_id
 * @property string $name
 * @property integer $sort
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends ActiveRecord
{
    //分类状态 1-正常 2-已删除
    const STATUS_NORMAL = 1;
    const STATUS_DEL    = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'user_id', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function behaviors()
    {
        return [
            //时间字段
            [
                'class' => TimestampBehavior::className()
            ],
            //当前登录用户
            [
                'class'      => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['user_id'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['user_id']
                ],
                'value' => function() {
                    return Yii::$app->user->identity->getId();
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => '分类ID',
            'parent_id'  => '所属分类',
            'user_id'    => '作者',
            'name'       => '分类名称',
            'sort'       => '排序',
            'status'     => '分类状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function statusList()
    {
        return [
            self::STATUS_NORMAL => '正常',
            self::STATUS_DEL    => '已删除'
        ];
    }

    public static function getStatus($status = self::STATUS_NORMAL)
    {
        return self::statusList()[$status];
    }

    public static function getAuthorName($uid = 0)
    {
        $author = User::findOne($uid);
        return $author['username'];
    }

    /**
     * 获取一级分类
     *
     * @return array
     */
    public static function getParents()
    {
        $category = self::findAll(['parent_id' => 0]);
        $data = [
            0 => '--无--'
        ];
        foreach ($category as $v) {
            $data[$v->id] =  $v->name;
        }
        return $data;
    }

    /**
     * 获取分类名称
     *
     * @param int $id
     *
     * @return mixed
     */
    public static function getCategoryName($id = 0)
    {
        $data = self::findOne($id);
        return $data['name'];
    }
}
