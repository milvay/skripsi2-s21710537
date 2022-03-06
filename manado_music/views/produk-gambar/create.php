<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProdukGambar */

$this->title = Yii::t('app', 'Create Produk Gambar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produk Gambars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produk-gambar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
