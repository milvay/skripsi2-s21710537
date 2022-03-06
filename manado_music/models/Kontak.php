<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kontak".
 *
 * @property integer $id
 * @property string $jenis_kontak
 * @property string $kontak
 * @property string $aktivasi
 */
class Kontak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kontak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jenis_kontak', 'kontak'], 'required'],
            [['jenis_kontak', 'kontak', 'aktivasi'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'jenis_kontak' => Yii::t('app', 'Jenis Kontak'),
            'kontak' => Yii::t('app', 'Kontak'),
            'aktivasi' => Yii::t('app', 'Aktivasi'),
        ];
    }
}
