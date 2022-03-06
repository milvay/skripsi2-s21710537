<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profil".
 *
 * @property integer $id
 * @property string $tentang
 */
class Profil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tentang'], 'required'],
            [['tentang'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tentang' => Yii::t('app', 'Tentang'),
        ];
    }
}
