<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yii2_post".
 *
 * @property string $id
 * @property string $category_id
 * @property string $title
 * @property string $alias
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    //用户状态 1-正常 2-已删除
    const STATUS_NORMAL = 1;
    const STATUS_DEL    = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['alias'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => '内容编号',
            'category_id' => '分类id',
            'title'       => '标题',
            'alias'       => '别名',
            'status'      => '状态',
            'created_at'  => '创建时间',
            'updated_at'  => '更新时间',
        ];
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
}
