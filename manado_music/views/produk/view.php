<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\Button;
use yii\bootstrap\ButtonGroup;

/* @var $this yii\web\View */
/* @var $model app\models\Produk */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produk'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produk-view">
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
                        'label' => "Tambah Produk",
                        'tagName' => 'a',
                        'options' => [
                            'href'=> Url::to(['create']),
                            'class' => 'btn btn-success',
                        ],
                    ],
                    [
                        'label' => 'Edit ('.$model->nama.')',
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
    <div class="row">
      <div class="col-md-12">
        <?php foreach($gambar as $g => $gbr):?>
          <?php
            $path = Yii::$app->request->baseUrl."/gambar/produk/".$gbr->gambar;
            $file_parts = pathinfo($path);
            if($file_parts['extension'] == "mp4"):?>
              <video  class='ft-form-produk' controls>
                <source src="<?=$path?>" type="video/mp4">
              </video>
          <?php  else: ?>
              <img src='<?php echo Yii::$app->request->baseUrl; ?>/gambar/produk/<?php echo $gbr->gambar;?>' class='ft-form-produk'>
          <?php endif;?>
        <?php endforeach;?>
      </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama',
            [
                'attribute' => 'jenis',
                'format' => 'raw',
                'value' => $model->jenis0->jenis,
            ],
            [
                'attribute' => 'satuan',
                'format' => 'raw',
                'value' => function($model){
                    return $model->satuan0->satuan;
                },  
            ],
            [
                'attribute' => 'harga_jual',
                'format' => 'raw',
                'value' => function($model){
                  return "Rp ".number_format($model->harga_jual,0,',','.');
                },
            ],
            // 'barcode:ntext',
            // [
            //     'attribute' => 'deskripsi',
            //     'format' => 'raw'
            // ],
            'aktivasi:ntext',
            'tanggal_input'
        ],
    ]) ?>

</div>
