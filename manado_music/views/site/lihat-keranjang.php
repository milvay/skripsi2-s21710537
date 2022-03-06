<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\TransaksiSearch;
use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\helpers\Json;
use yii\db\Query;
use kartik\select2\Select2;
use yii\httpclient\Client;

$connection = \Yii::$app->db;
$client = new Client();

$this->title = Yii::t('app', 'Daftar belanja');
$this->params['breadcrumbs'][] = $this->title;

$wilSQL = $connection->createCommand("SELECT * FROM wilayah WHERE aktivasi='Aktif' ORDER BY nama ASC");

$cekAvSQL = $connection->createCommand("SELECT * FROM transaksi WHERE status='Booking1' AND ip='$ip'")->queryAll();

$data_wilayah = [];


if(@fopen("https://www.google.com", "r")) {
  $response_city = $client->createRequest()
      ->setHeaders(['key' => '342a8e29cf24c23aeeb403cc6f336fb5'])
      ->setMethod('GET')
      ->setUrl('https://api.rajaongkir.com/starter/city')
      // ->setData(['nomor' => '8825112058773010', 'kurir' => 'jne', 'type'=>'awb'])
      ->send();
  $data_city = $response_city->data;
  $data_city_list = $data_city['rajaongkir']['results'];
}else{
  $data_city_list = [
    [
      'city_id'=>"",
      'city_name'=>null,
      'province'=>"Connection failed"
    ]
  ];
}

?>
<div class="transaksi-index">

<?php if($cekAvSQL != NULL):?>

<?php Pjax::begin(['id'=>'pjx-keranjang-index','enablePushState'=>false]); ?>
    <?php 
        $amount = 0;
        $j_h = 0;
        $j_f = 0;
        $diskon = 0;
        $Tdiskon = 0;
        $brt = 0;
         if (!empty($dataProvider->getModels())) {
            foreach ($dataProvider->getModels() as $key => $val) {
                $tmp = $val->harga_jual * $val->jumlah;
                $amount += $tmp;
                $tmp_brt = $val->berat * $val->jumlah;
                $brt += $tmp_brt;
                if($val->diskon_jumlah_beli != 0 && $val->free_diskon != 0 || $val->diskon_jumlah_beli != '' && $val->free_diskon != '' || $val->diskon_jumlah_beli != NULL && $val->free_diskon != NULL):
                    $t_ = 0;
                    if($val->jumlah >= $val->diskon_jumlah_beli):
                        $t_ = (floor($val->jumlah / $val->diskon_jumlah_beli)*$val->free_diskon)*$val->harga_jual;
                        $diskon += $t_;
                    endif;
                endif;
            }
            $Tdiskon = number_format($diskon,0,',','.').",00";
        }
        $Tamount = number_format($amount,0,',','.').",00";
        $total_harga_item = $amount-$diskon;
    ?>

    <?php
        $this->registerJs("
            $('#pjx-hasil-jual').html('".$Tamount."');
            $('#pjx-hasil-diskon').html('".$Tdiskon."');
            $('#pjx-hasil-berat').html('".$brt."');
            $('#konfirmasi-berat').val('".$brt."');
            $('#konfirmasi-jumlah_harga_item').val('".$total_harga_item."');
        ");
    ?>
<?php Pjax::end(); ?>

<?php Pjax::begin(['id'=>'pjx-keranjang','enablePushState'=>false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'ip:ntext',
            //'nama_produk:ntext',
            [
                'attribute' => 'nama_produk',
                'format' => 'raw',
                'value' => function($model){
                    $nama = $model->nama_produk;
                    $satuan = $model->satuan;
                    $berat = $model->berat;
                    $beli = $model->diskon_jumlah_beli;
                    $gratis = $model->free_diskon;

                    if($beli != null || $beli != '' && $gratis != null || $gratis != ''):
                        $diskon = "Beli ".$beli." Gratis ".$gratis;
                    else:
                        $diskon = "Tidak diskon";
                    endif;

                    $tampil = "<p style='font-size:0.8em;'><b style='color:##0b0259;font-size:1em;'>".$nama."</b>  - 1x(".$berat.' '.$satuan.")<br>".$diskon."</p>";
                    return $tampil;
                },
                'footer' => "<div style='text-transform:center;'>Jumlah</div><div style='text-transform:center;'>Diskon</div>",
            ],
            //'jenis:ntext',
            // 'satuan:ntext',
            // [
            //     'attribute' => 'diskon_jumlah_beli',
            //     'header' => 'Diskon',
            //     'format' => 'raw',
            //     'value' => function($model){
            //         $beli = $model->diskon_jumlah_beli;
            //         $gratis = $model->free_diskon;
            //         if($beli != null || $beli != '' && $gratis != null || $gratis != ''):
            //             return "Beli ".$beli." Gratis ".$gratis;
            //         else:
            //             return "Tidak diskon";
            //         endif;
            //     }
            // ],
            // 'harga_pokok:ntext',
            // echo Editable::widget([
            //     'model' => $model, 
            //     'attribute' => 'rating',
            //     'type' => 'primary',
            //     'size'=> 'lg',
            //     'inputType' => Editable::INPUT_RATING,
            //     'editableValueOptions' => ['class' => 'text-success h3']
            // ]);
            [
                'attribute' => 'harga_jual',
                'format' => 'raw',
                'value' => function($model){
                    //$total += $model->harga_jual;
                    return "<span style='font-size:0.8em;float:left;'>Rp</span> <span style='float:right;font-size:0.8em;'>".number_format($model->harga_jual,0,',','.').",00</span>";
                },
                'footer' => "<div style='text-align:left;'>Rp <span id='pjx-hasil-jual' style='text-align:right;float:rigt;font-size:1.0em;'>".$Tamount.",00</span></div><div style='text-align:left;'>Rp <span id='pjx-hasil-diskon' style='text-align:right;float:rigt;font-size:1.0em;'>".$Tdiskon.",00</span></div>",
            ],
            // 'deskripsi:ntext',
            // 'gambar:ntext',
            // [
            //     'class'=>'kartik\grid\EditableColumn',
            //     'width' => "100px",
            //     'attribute' => 'jumlah',
            //     'filter' => false,
            //     'editableOptions' => [
            //         'inputType'=>Editable::INPUT_TEXT,
            //         'asPopover' => false,
            //         'options'=>[
            //             'class'=>'form-control',
            //             'style' => 'width:100%;margin-left:2px;'
            //             //'pluginOptions'=>['min'=>1, 'max'=>4]
            //         ],
            //         'formOptions' => ['action' => 'edit-jumlah-keranjang'],
            //     ],
            // ],
            [
                'attribute' => 'jumlah',
                'filter' => false,
                'format' => 'raw',
                'value' => function($model){
                    Pjax::begin(['id'=>'tambah-kurang-'.$model->id, 'enablePushState' => false]);
                        $this->registerJs("
                            $('.jumlah-".$model->id."').html('".$model->jumlah."');
                        ");
                    Pjax::end();

                    $push = Html::a(Yii::t('app', '<span class="fa fa-plus-circle tambah-'.$model->id.'" id="tambah-jumlah"></span>'), ['update-jumlah','act'=>1,'idp'=>$model->id], [
                            //'id' => 'tambah-jumlah',
                            'onclick' => "
                                $.ajax({
                                    url: '".Url::to(['update-jumlah','act'=>'1','idp'=>$model->id])."',
                                    type: 'POST',
                                    success: function() {
                                        $.pjax.reload({container:'#pjx-keranjang-index', async:false});
                                        $.pjax.reload({container:'#tambah-kurang-".$model->id."', async:false});
                                        cekRequest();
                                    }
                                });
                                return false;
                            "
                        ]);
                    $queve =  Html::a(Yii::t('app', '<span class="fa fa-minus-circle kurang-'.$model->id.'" id="kurang-jumlah"></span>'), ['update-jumlah','act'=>0,'idp'=>$model->id], [
                            //'id' => 'tambah-jumlah',
                            'onclick' => "
                                $.ajax({
                                    url: '".Url::to(['update-jumlah','act'=>'0','idp'=>$model->id])."',
                                    type: 'POST',
                                    success: function() {
                                        $.pjax.reload({container:'#pjx-keranjang-index', async:false});
                                        $.pjax.reload({container:'#tambah-kurang-".$model->id."', async:false});
                                        cekRequest();
                                    }
                                });
                                return false;
                            "
                        ]);
                        echo "<span id='pjx-hasil-berat' style='display:none;'></span>";
                    return $queve."<span style='padding-left:5px;padding-right:5px;' type='number' id='jumlah-keranjang' class='jumlah-".$model->id."' contentEditable='true' onblur='getJumlah(".$model->id.")'>".$model->jumlah."</span>".$push;
                }
            ],
            // 'status:ntext',
            // 'no_transaksi:ntext',
            // 'nama_pelanggan:ntext',
            // 'no_telepon:ntext',
            // 'tanggal_expired:ntext',
            // 'diskon_jumlah_beli',
            // 'free_diskon',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'options' => ['style' => "width:90px;"],
                'template' => '{delete}',
                'buttons' => [
                    // 'view' => function ($url, $model) {
                    //         return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    //             'title' => Yii::t('app', 'View'),
                    //             // 'class' => 'btn-ajax-modal',
                    //             // 'id' => 'activity-view-link',
                    //             // 'data-toggle' => 'modal',
                    //             // 'data-target' => '#myModal',
                    //     ]);
                    // },
                    'delete' => function ($url, $model) {
                            return Html::a('<span class="fa fa-close" style="font-size:1.3em;float:right;vertical-align:middle;margin-right:20px;"></span>', '#', [
                                'title' => Yii::t('app', 'Hapus Item'),
                                //'data-confirm' => 'Yakin ingin menghapus?',
                                'onclick' => "
                                    if(confirm('Yakin ingin menghapus item ?')){
                                        $.ajax({
                                            url: '".$url."',
                                            type: 'POST',
                                            success: function() {
                                                $.pjax.reload({container:'#pjx-keranjang', async:false});
                                                $.pjax.reload({container:'#keranjang-pesan', async:false});
                                                $.pjax.reload({container:'#count-keranjang', async:false});
                                            }
                                        });
                                        return false;
                                    }
                                "
                                // 'id' => 'activity-update-link',
                                // 'data-toggle' => 'modal',
                                // 'class' => 'btn-ajax-modal',
                                // 'data-target' => '#myModal',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'delete'):
                        return Url::toRoute(['delete-keranjang', 'id' => $model->id]);
                    endif;
                }
            ],
        ],
        'id' => 'pjax-gridview-keranjang',
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
            'heading'=>"Keranjang Pembelian",
            'footer' => false,
        ],
    ]); ?>

<?php Pjax::end(); ?>
  <div class="row">
    <div class="konfirmasi-form">
        <p style="text-transform:uppercase;text-align:center;font-weight:bold;color:#fff;font-size:1.5em;">Lengkapi data</p>
        <?php $form = ActiveForm::begin(['id'=>'id-konnfirmasi', 'options' => ['enctype' => 'multipart/form-data']]); ?>

          <div class="col-md-6">
            <?= $form->field($model, 'nama_pelanggan')->textInput(['placeholder' => 'Nama Pelanggan (*)','maxLength'=>40])->label(false) ?>

              <?= $form->field($model, 'no_telepon')->textInput(['placeholder' => 'Nomor HP/Whatsapp (*)','maxLength'=>16])->label(false) ?>

              <?= $form->field($model, 'bank')->dropDownList([ 
                  'BCA' => 'BCA',
                  'BNI' => 'BNI',
                  'BRI' => 'BRI',
                  'DANAMON' => 'DANAMON',
                  'Mandiri' => 'Mandiri',
              ], ['prompt' => 'Nama BANK (*)'])->label(false) ?>

              <?= $form->field($model, 'no_rek_pelanggan')->textInput(['placeholder' => 'No. Rekening Pelanggan (*)','maxLength'=>20])->label(false) ?>

              <?= $form->field($model, 'rek_a_n')->textInput(['placeholder' => 'Rekening Atas Nama (*)','maxLength'=>40])->label(false) ?>
          </div>
          <div class="col-md-6">
            <?= $form->field($model, 'wilayah')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($data_city_list,'city_id', 'city_name','province'),
                'options' => [
                  'id' => "id-wilayah",
                  'placeholder' => "Pilih kota anda (*)",
                  'onchange' => "cekRequest()",
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);?>

            <?= $form->field($model, 'alamat_lengkap')->textarea(['placeholder'=>'Alamat Lengkap Pengiriman (*)','rows' => 4,'style'=>'resize:none;height:50px;'])->label(false) ?>

            <?= $form->field($model, 'jasa_pengiriman')->dropDownList([ 
                'jne' => 'JNE',
                'pos' => 'POS',
                'tiki' => 'TIKI',
              ], 
              [
                'id' => "id-kurir",
                'onchange' => "cekRequest()",
                'prompt' => 'Pilih Kurir (*)'
              ])->label(false) ?>
            
            <div id="pilih-ongkir">
              <?= $form->field($model, 'jasa')->textInput(['placeholder' => 'Ongkir & Lama Pengiriman (*)','readOnly'=>true])->label(false) ?>
            </div>
            
            <?= $form->field($model, 'berat')->hiddenInput()->label(false); ?>

            <?= $form->field($model, 'jumlah_harga_item')->hiddenInput()->label(false); ?>


          </div>
            <div class="form-group" style="clear:left;text-align:center;margin-top:10px;margin-bottom:-5px;">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Lanjutkan') : Yii::t('app', 'Lanjut Pembayaran'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','data-confirm'=>'Silahkan dilanjutkan jika data telah benar']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
  </div>
  <script>
    function getJumlah(id)
    {
      var jumItem = $('#jumlah-keranjang').text();
      $.ajax({
        url: 'update-jumlah2',
        type: 'POST',
        data: "id="+id+"&jumItem="+jumItem,
        success: function(){
          $.pjax.reload({container:'#pjx-keranjang-index', async:false});
          cekRequest();                              
        }
      });
    }
    function cekRequest(){
      var label = $('#id-wilayah option:selected').val();
      var kurir = $('#id-kurir option:selected').val();
      var berat = $('#pjx-hasil-berat').text();
      if(label && kurir && label != 'Pilih kota anda (*)' && kurir != 'Pilih Kurir (*)'){
        $.ajax({
          url:'pilih-ongkir',
          type:'post',
          data:"destination="+label+"&kurir="+kurir+"&berat="+berat,
          success:function(data){
            $('#pilih-ongkir').html(data);
          }
        })
      }
    }
    
    input = document.querySelector('#jumlah-keranjang');

    settings = {
      maxLen: 3,
    }

    keys = {
      'backspace': 8,
      'shift': 16,
      'ctrl': 17,
      'alt': 18,
      'delete': 46,
      // 'cmd':
      'leftArrow': 37,
      'upArrow': 38,
      'rightArrow': 39,
      'downArrow': 40,
    }

    utils = {
      special: {},
      navigational: {},
      isSpecial(e) {
        return typeof this.special[e.keyCode] !== 'undefined';
      },
      isNavigational(e) {
        return typeof this.navigational[e.keyCode] !== 'undefined';
      }
    }

    utils.special[keys['backspace']] = true;
    utils.special[keys['shift']] = true;
    utils.special[keys['ctrl']] = true;
    utils.special[keys['alt']] = true;
    utils.special[keys['delete']] = true;

    utils.navigational[keys['upArrow']] = true;
    utils.navigational[keys['downArrow']] = true;
    utils.navigational[keys['leftArrow']] = true;
    utils.navigational[keys['rightArrow']] = true;

    input.addEventListener('keydown', function(event) {
      let len = event.target.innerText.trim().length;
      hasSelection = false;
      selection = window.getSelection();
      isSpecial = utils.isSpecial(event);
      isNavigational = utils.isNavigational(event);
      
      if (selection) {
        hasSelection = !!selection.toString();
      }
      
      if (isSpecial || isNavigational) {
        return true;
      }
      
      if (len >= settings.maxLen && !hasSelection) {
        event.preventDefault();
        return false;
      }
      
    });
  </script>
  <?php
    $this->registerJS("
      var jumItem = $('#jumlah-keranjang').text();

      $('#jumlah-keranjang').keypress(function(e) {

        var keycode = e.charCode || e.keyCode;
        if (keycode  == 32) { 
          return false;
        }
        if (isNaN(String.fromCharCode(e.which))) e.preventDefault();
      });
    ");
  ?>
<?php else:?>
    <b><i>Tidak ada kerajang belanja</i></b>
<?php endif;?>
</div>