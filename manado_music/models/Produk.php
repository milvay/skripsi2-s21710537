<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produk".
 *
 * @property integer $id
 * @property integer $nama
 * @property integer $jenis
 * @property integer $satuan
 * @property string $harga_pokok
 * @property string $barcode
 * @property string $harga_jual
 * @property string $deskripsi
 * @property string $aktivasi
 * @property integer $diskon_jumlah_beli
 * @property integer $free_diskon
 * @property string $tanggal_input
 *
 * @property Satuan $satuan0
 * @property Jenis $jenis0
 * @property ProdukGambar[] $produkGambars
 */
class Produk extends \yii\db\ActiveRecord
{
    public $gambar;
    public static function tableName()
    {
        return 'produk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'jenis', 'satuan', 'berat', 'harga_jual', 'tanggal_input', 'deskripsi', 'aktivasi'], 'required','message' => ''],
            [['jenis', 'satuan', 'berat'], 'integer'],
            [['gambar','file'],
                'file',
                'extensions' => 'jpg, jpeg, png',
                'skipOnEmpty'=>true, 
                'on'=>'update',
                'maxSize' => 1024*1024*15,
                'tooBig' => 'File tidak boleh lebih dari 15Mb',
            ],
            [['nama', 'barcode', 'harga_jual', 'deskripsi', 'aktivasi', 'tanggal_input'], 'string'],
            [['satuan'], 'exist', 'skipOnError' => true, 'targetClass' => Satuan::className(), 'targetAttribute' => ['satuan' => 'id']],
            [['jenis'], 'exist', 'skipOnError' => true, 'targetClass' => Jenis::className(), 'targetAttribute' => ['jenis' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama' => Yii::t('app', 'Nama'),
            'gambar' => Yii::t('app', 'Gambar'),
            'jenis' => Yii::t('app', 'Kategori'),
            'satuan' => Yii::t('app', 'Satuan'),
            'berat' => Yii::t('app', 'Nilai Satuan'),
            'barcode' => Yii::t('app', 'Barcode'),
            'harga_jual' => Yii::t('app', 'Harga Jual'),
            'deskripsi' => Yii::t('app', 'Deskripsi'),
            'aktivasi' => Yii::t('app', 'Aktivasi'),
            'tanggal_input' => Yii::t('app', 'Tanggal Input'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan0()
    {
        return $this->hasOne(Satuan::className(), ['id' => 'satuan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenis0()
    {
        return $this->hasOne(Jenis::className(), ['id' => 'jenis']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdukGambars()
    {
        return $this->hasMany(ProdukGambar::className(), ['produk' => 'id']);
    }
}
