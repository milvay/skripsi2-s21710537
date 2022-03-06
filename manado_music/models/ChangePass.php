<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ChangePass extends Model
{
    public $old;
    public $new;
    public $confirm;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['old', 'new', 'confirm'], 'required', 'message'=>' '],
        ];
    }

    public function attributeLabels()
    {
        return [
            'old' => 'Password Lama',
            'new' => 'Password Baru',
            'confirm' => 'Konfirmasi Password Baru',
        ];
    }
}
