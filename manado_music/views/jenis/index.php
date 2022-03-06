<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\JenisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Kategori');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?PHP

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = getUserIP();

$user_ip; // Output IP address [Ex: 177.87.193.134]


?>
    <p>
        <?php 
            $ip = Yii::$app->getRequest()->getUserIP();
            $ip."<br>";
            $myIp = getHostByName(getHostName());
            $myIp."<br>";
            $ip2 = getenv("REMOTE_ADDR");
            $ip2;
            $IPq = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
            $computerName = gethostbyaddr($IPq)."<br>";

            $IPq." ".$computerName;
        ?>
        <?= Html::a(Yii::t('app', 'Tambah Kategori'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        // $this->registerJs("
        //     $('#myModal').on('show.bs.modal', function (event) {
        //         var button = $(event.relatedTarget)
        //         var modal = $(this)
        //         var title = button.data('title') 
        //         var href = button.attr('href') 
        //         modal.find('.modal-title').html(title)
        //         modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        //         $.post(href)
        //             .done(function( data ) {
        //                 modal.find('.modal-body').html(data)
        //             });
        //         });
        // ");

        // Modal::begin([
        //     'header' => '<h4><b>'.Yii::t('app','Form Kategori').'</b></h4>',
        //     'id' => 'modal',
        //     'size' => 'modal-lg',
        // ]);

        // echo "<div id='modalContent'></div>";

        // Modal::end();

        // Modal::begin([
        //     'header' => '<h4><b>'.Yii::t('app','Kategori').'</b></h4>',
        //     'id' => 'myModal',
        //     'size' => 'modal-lg',
        // ]);

        // echo "<div id='modalContent'></div>";

        // Modal::end();
    ?> 
<?php Pjax::begin(['id' => 'kategoriGrid', 'enablePushState' => false]); ?>
    <?= GridView::widget([
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
            'jenis:ntext',
            [
                'attribute' => 'keterangan',
                'format' => 'raw',
            ],
            [
                'attribute' => 'aktivasi',
                'format' => 'raw',
                'filter'=> ['Aktif'=>'Aktif','Tidak Aktif'=>'Tidak Aktif'],
            ],
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
