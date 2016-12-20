<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user_group}}".
 *
 * @property string $id
 * @property string $name
 * @property string $introduce
 * @property string $icon
 * @property integer $status
 * @property integer $sort_order
 * @property string $created_at
 * @property string $updated_at
 */
class UserGroup extends ActiveRecord
{
    //用户状态 1-正常 2-已删除
    const STATUS_NORMAL = 1;
    const STATUS_DEL    = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sort_order', 'created_at', 'updated_at'], 'integer'],
            [['name', 'introduce'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['introduce'], 'string', 'max' => 2000],
            [['icon'], 'string', 'max' => 100],
        ];
    }

    public function behaviors()
    {
        return [
            //时间字段
            [
                'class' => TimestampBehavior::className()
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => '用户组编号',
            'name'       => '用户组名称',
            'introduce'  => '用户组描述',
            'icon'       => '图标',
            'status'     => '用户组状态',
            'sort_order' => '排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return UserGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserGroupQuery(get_called_class());
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

    /**
     * 查询用户组名称或者列表项
     *
     * @param string $id
     * @return array|string
     */
    public static function findGroupName($id = '')
    {
        $data = $id > 0 ? self::findOne(['id' => $id]) : self::findAll(['status' => self::STATUS_NORMAL]);
        $res = [];
        if (count($data) > 1) {
            foreach ($data as $v) {
                $res[$v->id] = $v->name;
            }
            return $res;
        } else {
            return $data->name;
        }
    }
}
