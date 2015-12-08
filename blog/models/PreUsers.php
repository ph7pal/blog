<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "pre_users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $truename
 * @property string $email
 * @property integer $groupid
 * @property string $register_ip
 * @property string $last_login_ip
 * @property integer $register_time
 * @property integer $last_login_time
 * @property integer $login_count
 * @property integer $status
 * @property integer $email_status
 * @property integer $reputation
 * @property integer $badge
 * @property integer $posts
 * @property integer $answers
 * @property integer $tips
 * @property integer $favors
 * @property integer $fans
 * @property integer $last_update
 * @property integer $hits
 * @property string $extra
 * @property integer $sex
 * @property integer $classify
 * @property integer $areaid
 * @property string $avatar
 * @property integer $creditStatus
 * @property string $tagids
 * @property string $content
 */
class PreUsers extends ActiveRecord implements IdentityInterface {

    public $authKey;
    public $accessToken;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pre_users';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'password', 'truename', 'email', 'register_ip', 'last_login_ip', 'status', 'email_status', 'reputation', 'badge', 'posts', 'answers', 'tips', 'favors', 'fans', 'last_update', 'hits', 'extra', 'areaid', 'avatar', 'creditStatus', 'tagids', 'content'], 'required'],
            [['groupid', 'register_time', 'last_login_time', 'login_count', 'status', 'email_status', 'reputation', 'badge', 'posts', 'answers', 'tips', 'favors', 'fans', 'last_update', 'hits', 'sex', 'classify', 'areaid', 'creditStatus'], 'integer'],
            [['extra'], 'string'],
            [['username', 'password', 'truename', 'email', 'avatar', 'tagids', 'content'], 'string', 'max' => 255],
            [['register_ip', 'last_login_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'truename' => 'Truename',
            'email' => 'Email',
            'groupid' => 'Groupid',
            'register_ip' => 'Register Ip',
            'last_login_ip' => 'Last Login Ip',
            'register_time' => 'Register Time',
            'last_login_time' => 'Last Login Time',
            'login_count' => 'Login Count',
            'status' => 'Status',
            'email_status' => 'Email Status',
            'reputation' => 'Reputation',
            'badge' => 'Badge',
            'posts' => 'Posts',
            'answers' => 'Answers',
            'tips' => 'Tips',
            'favors' => 'Favors',
            'fans' => 'Fans',
            'last_update' => 'Last Update',
            'hits' => 'Hits',
            'extra' => 'Extra',
            'sex' => 'Sex',
            'classify' => '用户分类',
            'areaid' => '所在地区',
            'avatar' => '用户头像',
            'creditStatus' => '认证状态',
            'tagids' => '标签组',
            'content' => '个人简介',
        ];
    }

    public static function findByUsername($username) {
        return static::findOne(['truename' => $username, 'status' => 1]);
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->authKey;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password) {
        return $this->password === md5($password);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

}
