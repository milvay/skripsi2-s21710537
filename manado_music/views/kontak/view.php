<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\Button;
use yii\bootstrap\ButtonGroup;

/* @var $this yii\web\View */
/* @var $model app\models\Kontak */

$this->title = $model->jenis_kontak;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kontak'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kontak-view">
    <p>
        <?=
            ButtonGroup::widget([
                'encodeLabels'=>false,
                'buttons' => [
                    
                    // [
                    //     'label' => "Back",
                    //     'tagName' => 'a',
                    //     'options' => [
                    //         'href'=> Url::to(['index']),
                    //         'class' => 'btn btn-success',
                    //     ],
                    // ],
                    
                    [
                        'label' => "Tambah Kontak",
                        'tagName' => 'a',
                        'options' => [
                            'href'=> Url::to(['create']),
                            'class' => 'btn btn-success',
                        ],
                    ],
                    [
                        'label' => 'Edit ('.$model->jenis_kontak.')',
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
            [
                'attribute' => 'jenis_kontak',
                'format' => 'raw'
            ],
            'kontak:ntext',
            'aktivasi:ntext',
        ],
    ]) ?>

</div>
