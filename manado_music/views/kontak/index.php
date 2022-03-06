<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\KontakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Kontak');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("
    $('#sukses').delay(3000).fadeOut('slow');
");
?>

<?php if( Yii::$app->session->hasFlash('success') ):?>
    <div class="alert alert-success" id="sukses" style="bottom:0;position:fixed;right:10px;">
        <?= Yii::$app->session->getFlash('success')?>
    </div>
<?php elseif( Yii::$app->session->hasFlash('danger') ):?>
    <div class="alert alert-danger" id="sukses" style="bottom:0;position:fixed;">
        <?= Yii::$app->session->getFlash('danger')?>
    </div>
<?php endif;?>
<div class="kontak-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Tambah Kontak'), ['value' => Url::to('create'), 'class' => 'btn btn-success', 'id' => 'modalButton'])?>
    </p>

    <?php
        $this->registerJs("
            $('#myModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var modal = $(this)
                var title = button.data('title') 
                var href = button.attr('href') 
                modal.find('.modal-title').html(title)
                modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                $.post(href)
                    .done(function( data ) {
                        modal.find('.modal-body').html(data)
                    });
                });
        ");

        Modal::begin([
            'header' => '<h4><b>'.Yii::t('app','Form Kontak').'</b></h4>',
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();

        Modal::begin([
            'header' => '<h4><b>'.Yii::t('app','Kontak').'</b></h4>',
            'id' => 'myModal',
            'size' => 'modal-lg',
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?> 
<?php Pjax::begin(['id'=>'pjx-kontak-index', 'enablePushState'=>false]); ?>    
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
            [
                'attribute' => 'jenis_kontak',
                'format' => 'raw'
            ],
            'kontak:ntext',
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
                                'class' => 'btn-ajax-modal',
                                'id' => 'activity-view-link',
                                'data-toggle' => 'modal',
                                'data-target' => '#myModal',
                        ]);
                    },
                    'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'Update'),
                                'id' => 'activity-update-link',
                                'data-toggle' => 'modal',
                                'class' => 'btn-ajax-modal',
                                'data-target' => '#myModal',
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
<?php Pjax::end(); ?>
</div>
