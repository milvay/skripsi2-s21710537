<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produk_gambar".
 *
 * @property integer $id
 * @property integer $produk
 * @property string $gambar
 *
 * @property Produk $produk0
 */
class ProdukGambar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'produk_gambar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['produk'], 'integer'],
            [['gambar'], 'string'],
            [['produk'], 'exist', 'skipOnError' => true, 'targetClass' => Produk::className(), 'targetAttribute' => ['produk' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'produk' => Yii::t('app', 'Produk'),
            'gambar' => Yii::t('app', 'Gambar'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduk0()
    {
        return $this->hasOne(Produk::className(), ['id' => 'produk']);
    }
}
