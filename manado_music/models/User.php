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
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $level
 * @property string $nama_lengkap
 * @property string $email
 * @property string $no_telepon
 * @property string $no_ktp
 * @property string $accessToken
 * @property string $authKey
 * @property string $aktivasi
 *
 * @property DbPelanggan[] $dbPelanggans
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
            [['username','password'],'required','message'=>''],
            [['username', 'password', 'level', 'accessToken', 'authKey', 'aktivasi'], 'string'],
            [['username'], 'unique'],
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
            'level' => Yii::t('app', 'Level'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'aktivasi' => Yii::t('app', 'Aktivasi'),
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

    public function getDbPelanggans()
    {
        return $this->hasMany(DbPelanggan::className(), ['user_id' => 'id']);
    }
}
