<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Jenis */

$this->title = Yii::t('app', 'Tambah Jenis');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jenis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
