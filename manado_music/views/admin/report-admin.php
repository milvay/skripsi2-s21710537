<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title="Laporan";
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(['id' => 'report-bank', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="report-start">
    <?= $form->field($model, 'mulai')->widget(
        DatePicker::className(), [
            //'value' => date('Y-m-d'),
            'options' => [
                'placeholder' => 'Tanggal Awal',
            ],
            'pluginOptions' => [
                'format' => 'yyyy-m-d',
                'todayHighlight' => true
            ]
        ]
    )->label(false)?>
    </div>
    <div class="report-end">
    <?= $form->field($model, 'selesai')->widget(
        DatePicker::className(), [
            //'value' => date('Y-m-d'),
            'options' => [
                'placeholder' => 'Tanggal Akhir',
            ],
            'pluginOptions' => [
                'format' => 'yyyy-m-d',
                'todayHighlight' => true
            ]
        ]
    )->label(false)?>
    </div>
    <div style="clear:left;"></div>
    <div class="form-group" style="text-align:center;">
        <?= Html::submitButton(Yii::t('app', 'Tampilkan'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <br>

<?php Pjax::begin(['id'=>'pjx-report-admin','enablePushState'=>false]); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'ip',
                'format' => 'raw',
                'filter' => false,
            ],
            'no_transaksi:ntext',
            'nama_pelanggan:ntext',
            'no_telepon:ntext',
            // 'no_rek_pelanggan:ntext',
            // 'rek_a_n:ntext',
            // 'bank:ntext',
            // 'struk_bukti:ntext',
            // 'tanggal_pesan:ntext',
            // 'tanggal_expired:ntext',
            //'status:ntext',
            [
                'attribute' => 'struk_bukti',
                'format' => 'raw',
                'filter' => false
            ],

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
                        return Url::toRoute(['report-trx', 'id' => $model->id]);
                    // elseif ($action === 'update'):
                    //     return Url::toRoute(['update', 'id' => $model->id]);
                    // elseif ($action === 'delete'):
                    //     return Url::toRoute(['delete-operator', 'id' => $model->id]);
                    endif;
                }
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?>

</div>