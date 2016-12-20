<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_content}}".
 *
 * @property string $post_id
 * @property string $content
 * @property string $images
 * @property string $tags
 * @property string $views
 */
class PostContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'content'], 'required'],
            [['post_id', 'views'], 'integer'],
            [['content'], 'string'],
            [['images'], 'string', 'max' => 2000],
            [['tags'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => '内容id',
            'content' => '内容',
            'images'  => '图片',
            'tags'    => '标签',
            'views'   => '浏览次数',
        ];
    }
}
