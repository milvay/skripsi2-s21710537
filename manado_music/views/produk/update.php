<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Produk */

$this->title = Yii::t('app', 'Edit {modelClass}: ', [
    'modelClass' => 'Produk',
]) . $model->nama;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produk'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit');
?>
<div class="produk-update">

    <?= $this->render('_form', [
        'model' => $model,
        'bmodel' => $bmodel
    ]) ?>

</div>
