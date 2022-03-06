<?php

use yii\helpers\Html;
use yii\helpers\Url;

use kartik\editable\Editable;
use kartik\grid\GridView;
//use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\KonfirmasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transaksi');
$this->params['breadcrumbs'][] = $this->title;
//echo date('Y-m-d H:i:s');
?>
<div class="konfirmasi-index">

    <p style="text-transform:uppercase;text-align:center;font-weight:bold;font-size:1.3em;"><?= Html::encode($this->title) ?></p>

<?php Pjax::begin(['id'=>'pjx-view-admin','enablePushState'=>false]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],

            // [
            //     'attribute' => 'ip',
            //     'format' => 'raw',
            //     'filter' => false,
            // ],
            //'no_transaksi:ntext',
            [
                'attribute' => 'no_transaksi',
                'format' => 'raw',
                'value' => function($model){
                    $no_trx = $model->no_transaksi;
                    $struk = $model->struk_bukti;
                    return "No. Trx: ".$no_trx."<br>Struk: ".$struk;
                }
            ],
            //'nama_pelanggan:ntext',
            [
                'attribute' => 'nama_pelanggan',
                'format' => 'raw',
                'value' => function($model){
                    $nama = $model->nama_pelanggan;
                    $no_tlp = $model->no_telepon;
                    return $nama."<br>".$no_tlp;
                }
            ],
            //'no_telepon:ntext',
            // 'no_rek_pelanggan:ntext',
            // 'rek_a_n:ntext',
            // 'bank:ntext',
            // 'struk_bukti:ntext',
            // 'tanggal_pesan:ntext',
            // 'tanggal_expired:ntext',
            //'status:ntext',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => false
            ],
            // [
            //     'attribute' => 'struk_bukti',
            //     'format' => 'raw',
            //     'filter' => false
            // ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'options' => ['style' => "width:90px;"],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                            return Html::a('<span class="fa fa-eye"></span>', $url, [
                                'title' => Yii::t('app', 'View'),
                                // 'class' => 'btn-ajax-modal',
                                // 'id' => 'activity-view-link',
                                // 'data-toggle' => 'modal',
                                // 'data-target' => '#myModal',
                                'class' => 'btn btn-success',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view'):
                        return Url::toRoute(['view-trx', 'id' => $model->id]);
                    // elseif ($action === 'update'):
                    //     return Url::toRoute(['update', 'id' => $model->id]);
                    // elseif ($action === 'delete'):
                    //     return Url::toRoute(['delete-operator', 'id' => $model->id]);
                    endif;
                }
            ],
        ],
        'id' => 'pjax-gridview-index-operator',
        'pjax' => 0,
        'export'=>false,
        //'bordered' => true,
        //'striped' => false,
        //'condensed' => false,
        //'responsive' => false,
        'responsiveWrap' => false,
        'hover' => false,
        //'floatHeader' => false,
        'showPageSummary' => false,
        //'floatHeaderOptions' => ['scrollingTop' => 5],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading'=>"Tabel transaksi",
            'footer' => false,
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
