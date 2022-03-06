<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\helpers\Security;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $phone
 * @property string $authKey
 * @property string $accessToken
 * @property int $status_aktif
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','password','phone'],'required','message'=>''],
            [['username', 'password', 'authKey', 'accessToken'], 'string'],
            [['aktivasi'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'aktivasi' => Yii::t('app', 'Status Aktif'),
        ];
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public static function findByUsername($username)
    {
        return static::findOne(['username'=>$username]);
    }

    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }

    public function getAuthKey()
    {
    }
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function signup()
    {
        if($this->validate()){
            $user = new User();
            $user->username = $this->username;
            $user->phone = $this->phone;
            $user->password = sha1($this->password);
            $user->status_aktif = "1";
            $user->save();
            return $user;
        }
        return null;
    }
}
