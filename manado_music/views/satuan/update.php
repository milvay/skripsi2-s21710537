<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Satuan */

$this->title = Yii::t('app', 'Edit {modelClass}: ', [
    'modelClass' => 'Satuan',
]) . $model->satuan;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Satuan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit');
?>
<div class="satuan-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
