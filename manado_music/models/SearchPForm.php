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
class SearchPForm extends Model
{
    public $search;
    public $filterSelect;
    public $min;
    public $max;
    // public $lates;
    // public $longest;
    // public $atoz;
    // public $ztoa;
    // public $expensive;
    // public $inexpensive;

    public function rules()
    {
        return [
            // username and password are both required
            [['search','filterSelect'], 'string'],
            [['max', 'min'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'search' => Yii::t('app', 'Search'),
            'filterSelect' => Yii::t('app', 'Filter Select'),
            'max' => Yii::t('app', 'Maximum'),
            'min' => Yii::t('app', 'Minimum'),
        ];
    }
}
