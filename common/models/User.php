<?php

namespace common\models;

use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $position
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    //用户状态 1-正常 2-锁定 3-已删除
    const STATUS_NORMAL = 1;
    const STATUS_LOCK   = 2;
    const STATUS_DEL    = 3;

    //用户明文密码
    public $password = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['username'], 'required', 'on' => ['create']],
            [['password'], 'required', 'on' => ['create', 'frontend_update']],
            [['password'], 'string', 'min' => 6, 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 60],
            [['username'], 'unique'],
            [['email', 'group_id', 'status'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['position'], 'string', 'max' => 30],
            [['password_reset_token'], 'unique'],
        ];
    }

    public function behaviors()
    {
        return [
            //时间字段
            [
                'class' => TimestampBehavior::className()
            ],
            //密码加密
            [
                'class'      => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['password_hash'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['password_hash']
                ],
                'value' => function() {
                    if($this->isNewRecord || $this->password) {
                        return self::createPasswordHash($this->password);
                    } else {
                        return $this->password_hash;
                    }
                }
            ],
            //生成auth_key
            [
                'class'      => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['auth_key']
                ],
                'value' => self::createAuthKey($this->username.$this->password)
            ],
            //生成重置密码token
            [
                'class'      => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['password_reset_token']
                ],
                'value' => self::createResetPwdToken($this->password)
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => '用户编号',
            'group_id'             => '用户组',
            'username'             => '用户名',
            'auth_key'             => '验证key',
            'password'             => '密码',
            'password_hash'        => '密码Hash',
            'password_reset_token' => '重置密码token',
            'email'                => '电子邮箱',
            'position'             => '职位',
            'status'               => '用户状态',
            'created_at'           => '创建时间',
            'updated_at'           => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function createAuthKey($salt = '')
    {
        return hash('md5', $salt);
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function statusList()
    {
        return [
            self::STATUS_NORMAL => '正常',
            self::STATUS_LOCK   => '锁定',
            self::STATUS_DEL    => '已删除'
        ];
    }

    public static function getStatus($status = self::STATUS_NORMAL)
    {
        return self::statusList()[$status];
    }

    /**
     * 生成密码hash值
     *
     * @param string $password
     * @param int    $algo
     * @return bool|string
     */
    public static function createPasswordHash($password = '', $algo = PASSWORD_DEFAULT)
    {
        return password_hash($password, $algo);
    }

    /**
     * 验证密码
     *
     * @param string $password
     * @param string $password_hash
     * @return bool
     */
    public static function validatePassword($password = '', $password_hash = '')
    {
        if($password && $password_hash) {
            return password_verify($password, $password_hash);
        }
        return false;
    }

    /**
     * 生成重置密码token
     *
     * @param string $salt
     * @return string
     */
    public static function createResetPwdToken($salt = '')
    {
        $salt = $salt ? $salt : '';
        $salt .= time() . mt_rand(1, 9999);
        return hash('md5', $salt);
    }

    public static function findByUsername($username = '')
    {
        return self::findOne(['username' => $username]);
    }
}
