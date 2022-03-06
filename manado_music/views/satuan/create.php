<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Satuan */

$this->title = Yii::t('app', 'Tambah Satuan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Satuan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="satuan-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
