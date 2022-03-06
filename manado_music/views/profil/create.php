<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Profil */

$this->title = Yii::t('app', 'Tambah Profil');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profil'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profil-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
