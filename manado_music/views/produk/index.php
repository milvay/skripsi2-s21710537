<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProdukSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Produk');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produk-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Tambah Produk'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id'=>'pjax-produk','enablePushState'=>false]); ?>    
    <?= GridView::widget([
        'id' => 'produk-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
            if($model->aktivasi == 'Tidak Aktif' || $model->aktivasi == NULL):
                return ['class' => 'danger'];
            elseif($model->aktivasi == 'Aktif'):
                return ['class' => 'success'];
            endif;
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'nama',
                'format' => 'raw',
                /*'value' => function($model){
                    $gambar = Html::img("@web/gambar/produk/".$model->gambar, ['class'=>'gbr-produk-sml']);
                    $nama = $model->nama;
                    return $gambar."<br>".$nama;
                }*/
            ],
            [
                'attribute' => 'jenis',
                'format' => 'raw',
                'value' => function($model){
                    return $model->jenis0->jenis;
                }
            ],
            [
                'attribute' => 'harga_jual',
                'format' => 'raw',
                'value' => function($model){
                    return "Rp <span style='float:right;'>".number_format($model->harga_jual,0,',','.')."</span>";
                }
            ],
            // 'barcode:ntext',
            // 'deskripsi:ntext',
            // 'gambar:ntext',
            // 'aktivasi:ntext',
            // 'diskon_jumlah_beli',
            // 'free_diskon',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'options' => ['style' => "width:90px;"],
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'View'),
                                // 'class' => 'btn-ajax-modal',
                                // 'id' => 'activity-view-link',
                                // 'data-toggle' => 'modal',
                                // 'data-target' => '#myModal',
                        ]);
                    },
                    'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'Update'),
                                // 'id' => 'activity-update-link',
                                // 'data-toggle' => 'modal',
                                // 'class' => 'btn-ajax-modal',
                                // 'data-target' => '#myModal',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view'):
                        return Url::toRoute(['view', 'id' => $model->id]);
                    elseif ($action === 'update'):
                        return Url::toRoute(['update', 'id' => $model->id]);
                    // elseif ($action === 'delete'):
                    //     return Url::toRoute(['delete-operator', 'id' => $model->id]);
                    endif;
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
