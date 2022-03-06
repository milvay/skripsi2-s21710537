<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kontak */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Kontak',
]) . $model->jenis_kontak;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kontaks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="kontak-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
