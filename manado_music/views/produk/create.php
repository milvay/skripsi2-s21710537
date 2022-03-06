<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Produk */

$this->title = Yii::t('app', 'Tambah Produk');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produk'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produk-create">

    <?= $this->render('_form', [
        'model' => $model,
        'bmodel' => $bmodel
    ]) ?>

</div>
