<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Kontak */

$this->title = Yii::t('app', 'Tambah Kontak');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kontak'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kontak-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
