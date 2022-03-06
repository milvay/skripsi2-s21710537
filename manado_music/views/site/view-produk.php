<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\db\Query;
$connection = \Yii::$app->db;
$query = $connection->createCommand("SELECT * FROM produk_gambar WHERE produk='$model->id' ORDER BY id")->queryOne();

/* @var $this yii\web\View */
/* @var $model app\models\Produk */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produk'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


// $this->registerJs("
//     $('img').click(function(e){
        
//     });
// ");
?>

<div class="produk-view">
    <div class="row">
      <div class="col-md-12">
          <div class="col-md-4">
            <div class="col-md-12">
              <?php if($query["gambar"] != NULL): ?>
                <div id="full-size">
                <?php
                  $path2 = Yii::$app->request->baseUrl."/gambar/produk/".$query['gambar'];
                  $file_parts2 = pathinfo($path2);
                  if($file_parts2['extension'] == "mp4"):?>                
                  <video class='ft-form-produk' controls>
                    <source src="<?=$path2?>" type="video/mp4">
                  </video>
                  <img style="display:none;" src='' class='ft-view-produk'>
                <?php else:?>
                  <img src='<?php echo Yii::$app->request->baseUrl; ?>/gambar/produk/<?=$query["gambar"]?>' class='ft-view-produk'>
                  <video style="display:none;" class='ft-view-produk' controls>
                    <source src="" type="video/mp4">
                  </video>
                <?php endif;?>
                </div>
              <?php else:?>
                  <span class='fa fa-image ft-view-produk' id="full-size" style="font-size:13em;color:#ccc;"></span>
              <?php endif;?>
            </div>
            <div class="col-md-12">
              <?php foreach($gambar as $g => $gbr):?>
                <?php 
                  $path = Yii::$app->request->baseUrl."/gambar/produk/".$gbr->gambar;
                  $file_parts = pathinfo($path);
                  if($file_parts['extension'] == "mp4"):?>
                    <span>
                    <video id="<?=$gbr->id?>" src="<?=$path?>" class='ft-site-view-produks' onclick="
                      $('#full-size').find('video').find('source').attr('src',$(this).attr('src'));
                      $('#full-size').find('video').load();
                      $('#full-size').find('video').get(0).play();
                      $('#full-size video').show();
                      $('#full-size img').hide();
                  ">
                    </video>
                    <span style="cursor:pointer;position:absolute;margin-left:-60px;margin-top:20px;color:#fff;" onclick="
                      var videoID = $('#<?=$gbr->id?>');
                      var videoID = videoID.selector;
                      console.log(videoID);
                      $('#full-size').find('video').find('source').attr('src',$(videoID).attr('src'));
                      $('#full-size').find('video').load();
                      $('#full-size').find('video').get(0).play();
                      $('#full-size video').show();
                      $('#full-size img').hide();
                    ">PLAY</span>
                    </span>
                <?php  else:?>
                  <img src='<?php echo Yii::$app->request->baseUrl; ?>/gambar/produk/<?=$gbr->gambar?>' class='ft-site-view-produks' id="<?=$gbr->id?>" onclick="
                      $('#full-size img').attr('src',$(this).attr('src').replace());
                      $('#full-size').find('video').get(0).pause();
                      $('#full-size video').hide();
                      $('#full-size img').show();
                  ">
                <?php endif;?>
              <?php endforeach;?>
            </div>
            
            <div class="col-md-12">
              <?php
                $kategori = (new yii\db\Query())
                ->from('jenis')
                ->where("id='$model->jenis'")
                ->one();
                $sendText = "*".$kategori['jenis'].": ".$model->nama."*%0aHai kak, barang ini ready yah?";
                $wa = (new yii\db\Query())
                ->from('kontak')
                ->where("jenis_kontak like '%Whatsapp%'")
                ->one();
                if(!empty($wa)){
                  $kontak = $wa['kontak'];
                }else{
                  $kontak = "6281356337730";
                }
              ?>               
              <a href="https://wa.me/<?=$kontak?>?text=<?=$sendText?>" target="_blank">
                <span class='keranjang-view'>  
                  <span class="btn btn-success keranjang-view" id="update-active">   
                      <i class="fa fa-whatsapp"></i> Cek barang
                  </span>
                </span>
              </a>
            </div>
        </div>

        <div class="col-md-8">
            <table class="tbl-mi-ne">
                <tr class="tr-judul">
                    <td colspan="2" style="font-weight:bold;text-align:center;text-transform: uppercase;">
                        <?=$model->nama?>
                    </td>
                </tr>
                <tr class="tr-ganjil">
                    <td style="width:10%;font-weight:bold;text-transform: uppercase;">Kategori</td>
                    <td style="width:80%;"><?=$model->jenis0->jenis?></td>
                </tr>
                <tr class="tr-genap">
                    <td style="font-weight:bold;text-transform: uppercase;">Berat</td>
                    <td><?=$model->berat." ".$model->satuan0->satuan?></td>
                </tr>
                <tr class="tr-ganjil">
                    <td style="font-weight:bold;text-transform: uppercase;">Harga</td>
                    <td><?="Rp ".number_format($model->harga_jual,0,',','.')?></td>
                </tr>
                <tr class="tr-genap">
                    <td colspan="2">
                        <p style="text-transform: uppercase;font-weight: bold;">Deskripsi</p>
                        <p>
                            <?=$model->deskripsi?>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        </div>
    </div>
    <div style="clear:left;"></div>
</div>
