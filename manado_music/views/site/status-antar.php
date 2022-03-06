<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title='Status Pengiriman';
?>
<style>
  hr {
    /* margin-top:0; */
    margin-bottom:0;
    display:block;   
    background-color:#8e098b;
    height: 1px;
  }
  #tracking-pesanan{
    position: relative;
    margin-top: 20px;
    /* border:1px solid #000; */
  }
  #web-tracking{
    position: relative;
  }
  #jasa-pengiriman{
    padding-left:5px;
    padding-right:5px;
    padding-bottom:2px;
    padding-top:2px;
    border-radius: 7px;
    background-color: #ffd3ce;
    border: 1px solid #8c0e00;
  }
</style>

<div id="web-tracking">
  <div class="row"> 
    <div class="col-md-12">  
      <?php if($model->status=='Booking2'):?>
        <div class='color-circle'>
          <span class='fa fa-file-text'></span><span class='nomor'>1</span>
          <p>Pemesanan</p>
        </div>
        <div class='whiteblack-circle'>
          <span class='fa fa-eye'></span><span class='nomor'>2</span>
          <p>Diproses</p>
        </div>
        <div class='whiteblack-circle'>
          <span class='fa fa-money'></span><span class='nomor'>3</span>
          <p>Verifikasi</p>
        </div>
        <div class='whiteblack-circle'>
          <span class='fa fa-send'></span><span class='nomor'>4</span>
          <p>Pengantaran</p>
        </div>
        <div class='whiteblack-circle'>
          <span class='fa fa-flag'></span><span class='nomor'>5</span>
          <p>Selesai</p>
        </div>
      <?php elseif($model->status == 'Diproses'):?>
        <div class='color-circle'>	
          <span class='fa fa-file-text'></span><span class='nomor'>1</span>
          <p>Pemesanan</p>
        </div>
        <div class='color-circle'>
          <span class='fa fa-eye'></span><span class='nomor'>2</span>
          <p>Diproses</p>
        </div>
        <div class='whiteblack-circle'>
          <span class='fa fa-money'></span><span class='nomor'>3</span>
          <p>Verifikasi</p>
        </div>
      <?php elseif($model->status == 'Verifikasi'):?>
        <div class='color-circle'>	
          <span class='fa fa-file-text'></span><span class='nomor'>1</span>
          <p>Pemesanan</p>
        </div>
        <div class='color-circle'>
          <span class='fa fa-eye'></span><span class='nomor'>2</span>
          <p>Diproses</p>
        </div>
        <div class='color-circle'>
          <span class='fa fa-money'></span><span class='nomor'>3</span>
          <p>Verifikasi</p>
        </div>
      <?php else:?>
        <div class='whiteblack-circle'>
          <span class='fa fa-file-text'></span>
          <p>Pemesanan</p>
        </div>
        <div class='whiteblack-circle'>
          <span class='fa fa-eye'></span>
          <p>Diproses</p>
        </div>
        <div class='whiteblack-circle'>
          <span class='fa fa-money'></span>
          <p>Verifikasi</p>
        </div>
      <?php endif;?>
    </div>
  </div>
</div>

<?php if($model->status == "Verifikasi" || $model->status == "Selesai" || $model->status == "Pengantaran"):?>
  <div id="tracking-pesanan">
    <p>
      <b>DETAIL PENGIRIMAN</b>
    </p>
    <div>No. Resi : <?=$model->no_resi?> <span id="jasa-pengiriman"><?=$model->jasa_pengiriman?></span></div>
    <div>Pemesan : <?=$model->nama_pelanggan?></div>
    <hr>
	  <?php if($respon != "NOT FOUND" && $respon != NULL ):?>
     
    <div style="clear:left;">
      <?php
          // echo "<pre>";
          foreach($respon as $r => $rs):
            if($rs['result']){
              // print_r($rs['result']['manifest']);
              $manifest = $rs['result']['manifest'];
              krsort($manifest);
              foreach($manifest as $rr => $rss):
                  echo "<div id='list-tracking'><span class='fa fa-check' style='color:#1c9c0e;'></span>".$rss['manifest_description']."</div>";
                  echo "<br>";
              endforeach;
              // print_r($rs);
            }
          endforeach;
          // echo "</pre>";
      ?>
      </div>
    <?php else: ?>
      <div style="clear:left;">
          <b>Koneksi anda sedang offline</b>
      </div>
    <?php endif;?>
  </div>
<?php endif;?>
<div style="clear:left;"></div>