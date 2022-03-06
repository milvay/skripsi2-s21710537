<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Button;
use yii\bootstrap\ButtonGroup;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Profil */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profil'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profil-view">

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
                        'label' => 'Edit ('.$model->id.')',
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
                'attribute' => 'tentang',
                'format' => 'raw'
            ]
        ],
    ]) ?>

</div>
