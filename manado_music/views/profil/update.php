<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Profil */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Profil',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profil'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="profil-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
