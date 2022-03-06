<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jenis".
 *
 * @property integer $id
 * @property string $jenis
 * @property string $keterangan
 * @property string $aktivasi
 *
 * @property Produk[] $produks
 */
class Jenis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jenis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jenis','aktivasi'], 'required', 'message'=> ''],
            ['keterangan', 'filter', 'filter' => 'strip_tags'],
            [['jenis', 'keterangan', 'aktivasi'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'jenis' => Yii::t('app', 'Jenis'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'aktivasi' => Yii::t('app', 'Aktivasi'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduks()
    {
        return $this->hasMany(Produk::className(), ['jenis' => 'id']);
    }
}
