<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\Button;
use yii\bootstrap\ButtonGroup;

/* @var $this yii\web\View */
/* @var $model app\models\Satuan */

$this->title = $model->satuan;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Satuan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="satuan-view">
    <p>
        <?=
            ButtonGroup::widget([
                'encodeLabels'=>false,
                'buttons' => [
                    
                    [
                        'label' => "Back",
                        'tagName' => 'a',
                        'options' => [
                            'href'=> Url::to(['index']),
                            'class' => 'btn btn-success',
                        ],
                    ],
                    
                    [
                        'label' => "Tambah Satuan",
                        'tagName' => 'a',
                        'options' => [
                            'href'=> Url::to(['create']),
                            'class' => 'btn btn-success',
                        ],
                    ],
                    [
                        'label' => 'Edit ('.$model->satuan.')',
                        'tagName' => 'a',
                        'options' => [
                            'href' => url::to(['update','id'=>$model->id]),
                            'class' => 'btn btn-primary',
                        ],
                    ],                    
                ]
            ]);
        ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'satuan:ntext',
            [
                'attribute' => 'keterangan',
                'format' => 'raw'
            ]
        ],
    ]) ?>

</div>
