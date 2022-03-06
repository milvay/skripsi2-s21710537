<?php

namespace app\models;

use Yii;
use yii\base\Model;

class FilterHarga extends Model
{
    public $max;
    public $min;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['max', 'min'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'max' => Yii::t('app', 'Maximum'),
            'min' => Yii::t('app', 'Minimum'),
        ];
    }
}
