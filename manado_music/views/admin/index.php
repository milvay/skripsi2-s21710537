<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\KonfirmasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Welcome');
$this->params['breadcrumbs'][] = $this->title;
//echo date('Y-m-d H:i:s');
?>
<div class="admin-index">
    <p>
        Welcome back <b><?=$user->name?></b>
    </p>
</div>
