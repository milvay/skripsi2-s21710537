<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\db\Query;

$this->title = Yii::t('app', 'Bukti Bayar');
$connection = \Yii::$app->db;
$wilSQL = $connection->createCommand("SELECT * FROM wilayah WHERE aktivasi='Aktif' ORDER BY nama ASC");
$bankSQL = $connection->createCommand("SELECT * FROM bank WHERE aktivasi='Aktif' ORDER BY bank ASC")->queryAll();
$transaksiSQL = $connection->createCommand("SELECT * FROM transaksi WHERE ip='$model->ip' AND no_transaksi='$model->no_transaksi' ORDER BY nama_produk ASC")->queryAll();

?>
<style>
hr {
  /* margin-top:0; */
  margin-bottom:0;
  display:block;   
  background-color:#8e098b;
  height: 1px;
}
#no-rek{
  margin-left:50px;
}
#urut-bank{
  position:absolute;
  padding:5px;
  padding-top:2px;
  padding-bottom:2px;
  border-radius:50px;
  background-color:#fdc4f9;
  border:0.5px solid #000;
  color:#25a916;
  margin-top:5px;
}
#nama-bank{
  font-weight:normal;
  font-size:14px;
  padding-left:5px;
  padding-right:5px;
  border-radius:7px;
  background-color:#d2ffe7;
  border:1px solid #04acca;
}
#atas-nama-bank{
  margin-left:10%;
}
#atas-nama{
  font-size:15px;
  font-style:italic;
  font-weight:bold;
  padding-left:5px;
  padding-right:5px;
  border-radius:7px;
  background-color:#fef9bc;
  border:1px solid #caa304;
}
#no-rek{
  font-weight:bold;
}
@media screen and (min-width: 601px) {
  #no-rek {
    font-size: 30px;
  }
}

@media screen and (max-width: 600px) {
  #no-rek {
    font-size: 18px;
  }
}
</style>
<?php if($model != NULL):?>
    <div class="konfirmasi-detail-form">
        	<p style="text-align:center;margin-top:-10px;margin-bottom:-4px;font-size:1.3em;">Kode Pesanan : <b><?=$model->no_transaksi?></b></p>
        <?php $form = ActiveForm::begin(['id'=>'id-konnfirmasi', 'options' => ['enctype' => 'multipart/form-data']]); ?>
            <p>
                <span class='note-danger'>*)Simpan Kode Pesanan anda, Lakukan pembayaran sebelum batas waktu pembayaran dan nominal transaksi sesuai dengan Total Pembayaran.</span>
			      </p>
            <div class="row">
              <div class="col-md-6">
                <fieldset>
                  <legend>Batas waktu pembayaran</legend>
                    <p>
                      <b><?=date('d-F-Y H:i:s', strtotime($model->tanggal_expired))." WIB";?></b>
                </p>
                </fieldset>
                <br>

                <fieldset>
                    <legend>Pilih salah satu <b>Bank</b> untuk transaksi</legend>
                    <p>
                      <?php $no=1;foreach($bankSQL as $b => $bnk):?>
                        <div id="bank">
                          <span id="urut-bank"><span class="fa fa-check"></span></span>
                          <div id="no-rek">
                            <?=$bnk['no_rek']?>
                            <span id="nama-bank"><?=$bnk['bank']?></span>
                          </div>

                          <div id="atas-nama-bank" > a/n <span id="atas-nama"><?=$bnk['rek_a_n']?></span></div>
                          <hr> 
                        </div>
                      <?php $no++;endforeach;?>
                    </p>
                </fieldset>
                <br>
                <fieldset>
                    <legend>Pemesan</legend>
                <p><?=$model->nama_pelanggan?> (<?=$model->no_telepon?>)</p>
                    <div style="font-weight:bold;">Alamat Pengiriman:</div>

                    <p><?=$model->wilayah;?></p>

                    <?= $form->field($model, 'alamat_lengkap')->textarea(['placeholder'=>'Alamat Lengkap Pengiriman (*)','rows' => 3,'style'=>'resize:none;','readOnly'=>true])->label(false) ?>
                </fieldset>
                <br>
              </div>
              <div class="col-md-6">
                <fieldset>
                  <legend>Keranjang Belanja</legend>
                  <table style="width:100%;">
                  <tr class='tr-judul'>
                    <td>Nama Produk</td>
                    <td style="text-align:right;">Harga</td>
                    <td style="text-align:center;">Jumlah</td>
                    <td style="text-align:right;">Jumlah x Harga</td>
                  </tr>
                    <?php $i=0;$total = 0;$diskon=0;$subtotal=0;foreach($transaksiSQL as $t => $val):?>
                      <?php 
                          if($val['diskon_jumlah_beli'] != 0 && $val['free_diskon'] != 0 || $val['diskon_jumlah_beli'] != '' && $val['free_diskon'] != '' || $val['diskon_jumlah_beli'] != NULL && $val['free_diskon'] != NULL):
                              $t_ = 0;
                              if($val['jumlah'] >= $val['diskon_jumlah_beli']):
                                  $t_ = (floor($val['jumlah'] / $val['diskon_jumlah_beli'])*$val['free_diskon'])*$val['harga_jual'];
                                  $diskon += $t_;
                              endif;
                          endif;
                      ?>
                      <?php $jumlah = $val['jumlah']*$val['harga_jual'];?>
                      <?php if($i % 2 == 0):?>
                        <tr class='tr-ganjil'>
                          <td><?=$val['nama_produk']?></td>
                          <td style="text-align:right;"><?=number_format($val['harga_jual'],0,',','.').",00";?></td>
                          <td style="text-align:center;"><?=$val['jumlah']?></td>
                          <td style="text-align:right;"><?php
                            echo number_format($jumlah,0,',','.').",00";
                          ?></td>
                        </tr>
                      <?php else:?>
                        <tr class='tr-genap'>
                          <td><?=$val['nama_produk']?></td>
                          <td style="text-align:right;"><?=number_format($val['harga_jual'],0,',','.').",00";?></td>
                          <td style="text-align:center;"><?=$val['jumlah']?></td>
                          <td style="text-align:right;"><?php
                            echo number_format($jumlah,0,',','.').",00";
                          ?></td>
                        </tr>
                      <?php endif;?>
                      <?php $subtotal += $jumlah;?>
                    <?php $i++; endforeach;?>
                    <?php $total = $subtotal - $diskon;?>
                    <tr class="tr-footer" style="text-align:right;">
                      <td colspan="3">Subtotal</td>
                      <td><?=number_format($subtotal,0,',','.').",00"?></td>
                    </tr>
                    <tr class="tr-footer" style="text-align:right;">
                      <td colspan="3">Ongkos Kirim</td>
                      <td><?=number_format($model->ongkir,0,',','.').",00"?></td>
                    </tr>
                    <tr class="tr-footer" style="border-bottom:1px solid #fff;text-align:right;">
                      <td colspan="3">Diskon</td>
                      <td><?=number_format($diskon,0,',','.').",00"?></td>
                    </tr>
                    <tr class="tr-footer" style="text-align:right;">
                      <?php $total = $total + $model->ongkir;?>
                      <td colspan="3">Total Pembayaran</td>
                      <td><?=number_format($total,0,',','.').",00"?></td>
                    </tr>
                  </table>
                </fieldset>
                <br>
                <fieldset id="bukti-bayar">
                  <legend>Kirim Bukti Bayar</legend>
                <?=
                    $form->field($model, 'struk_bukti')->widget(FileInput::classname(), [
                        'options' => [
                            'id' => 'struk-id',
                            'class' => 'gambar-struk',
                            'style' => "float:left;",
                            'multiple' => false,
                            'accept' => 'image/*',
                        ],

                        'pluginOptions' => [
                            'allowedFileExtensions' => ['jpg','png','jpeg'],
                            'previewFileType' => 'image',
                            'showUpload' => false,
                            'showPreview' => false,
                            'showRemove' => false,
                            'showCaption' => true,
                            'maxFileSize'=>2048,
                            'browseIcon' => '<i class="fa fa-camera" style="width:50px;"></i>',
                            'browseLabel' => '',
                        ]
                    ])->label(false);
                ?> 
                </fieldset>
                <div class="form-group" style="clear:left;text-align:center;margin-top:10px;margin-bottom:0px;">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Lanjutkan') : Yii::t('app', 'Lanjutkan'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','data-confirm'=>'Silahkan dilanjutkan jika data telah benar']) ?>
                </div>
            </div>
          </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php else:?>
	<span style="color:#bf0005;"><b><i>Tidak ada transaksi</i></b></span>
<?php endif;?>