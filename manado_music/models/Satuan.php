<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "satuan".
 *
 * @property integer $id
 * @property string $satuan
 * @property string $keterangan
 *
 * @property Produk[] $produks
 */
class Satuan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'satuan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['satuan'],'required','message'=>''],
            [['satuan', 'keterangan'], 'string'],
            [['satuan'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'satuan' => Yii::t('app', 'Satuan'),
            'keterangan' => Yii::t('app', 'Keterangan'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduks()
    {
        return $this->hasMany(Produk::className(), ['satuan' => 'id']);
    }
}
