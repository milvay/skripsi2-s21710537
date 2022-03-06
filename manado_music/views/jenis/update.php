<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jenis */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Jenis',
]) . $model->jenis;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jenis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="jenis-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
