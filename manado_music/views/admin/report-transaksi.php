<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\db\Query;
$this->title='Detail Report Transaksi';

$connection = \Yii::$app->db;
$wilSQL = $connection->createCommand("SELECT * FROM wilayah WHERE aktivasi='Aktif' ORDER BY nama ASC");
$transaksiSQL = $connection->createCommand("SELECT * FROM transaksi WHERE ip='$model->ip' AND no_transaksi='$model->no_transaksi' ORDER BY nama_produk ASC")->queryAll();

?>
<?= Html::a(Yii::t('app', "<span class='fa fa-arrow-left'></span> Kembali"), ['admin/report-admin'], ['class' => 'btn btn-success','style'=>"top:60px;right:10px;position:fixed;"]) ?>
<p style="text-align:center;margin-top:-10px;margin-bottom:-4px;font-size:1.3em;">Kode Pesanan : <b><?=$model->no_transaksi?></b></p><br>
<?php $form = ActiveForm::begin(['id'=>'id-verifikasi', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <fieldset>
            <legend>Pelanggan</legend>
    		<p><b><?=$model->nama_pelanggan?>, (<?=$model->no_telepon?>)</b></p>
        </fieldset>
            <br>
            <fieldset>
                <legend>Alamat Pengiriman</legend>

                <p><?=$model->wilayah0->nama;?></p>

                <?= $form->field($model, 'alamat_lengkap')->textarea(['placeholder'=>'Alamat Lengkap Pengiriman (*)','rows' => 3,'style'=>'resize:none;','readOnly'=>true])->label(false) ?>
            </fieldset>
            <br>
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
            			<td><?=number_format($model->wilayah0->harga,0,',','.').",00"?></td>
            		</tr>
            		<tr class="tr-footer" style="border-bottom:1px solid #fff;text-align:right;">
            			<td colspan="3">Diskon</td>
            			<td><?=number_format($diskon,0,',','.').",00"?></td>
            		</tr>
            		<tr class="tr-footer" style="text-align:right;">
            			<?php $total = $total + $model->wilayah0->harga;?>
            			<td colspan="3">Total Pembayaran</td>
            			<td><?=number_format($total,0,',','.').",00"?></td>
            		</tr>
            	</table>
            </fieldset>
            <br>
	        <fieldset>
	            <legend>Rekening Pelanggan</legend>
	    		<p>Bank <b><?=$model->bank?></b> No.Rekening <b><?=$model->no_rek_pelanggan?></b> Rekening Atas Nama <b><?=$model->rek_a_n?></b></p>
	        </fieldset>
	        <br>
            <fieldset id="bukti-bayar">
            	<legend>Bukti Bayar</legend>
            	<?= Html::img("@web/gambar/bukti-bayar/$model->struk_bukti", ['class'=>'struk-bukti']);?> 
            </fieldset>
            <?php if($cek2SQL):?>
            <div class="form-group" style="clear:left;text-align:center;margin-top:10px;margin-bottom:0px;">
                <?= Html::submitButton(Yii::t('app', 'Verifikasi'), ['class' => 'btn btn-success','data-confirm'=>'Struk Bukti sudah benar?']) ?>
            </div>
        	<?php elseif($cek2SQL_v):?>
            <div class="form-group" style="clear:left;text-align:center;margin-top:10px;margin-bottom:0px;">
                <?= Html::submitButton(Yii::t('app', 'Kirim'), ['class' => 'btn btn-success','data-confirm'=>'Pesanan siap dikirim ?']) ?>
            </div>
        	<?php elseif($cek2SQL_s):?>
            <div class="form-group" style="clear:left;text-align:center;margin-top:10px;margin-bottom:0px;">
                <?= Html::submitButton(Yii::t('app', 'Selesai'), ['class' => 'btn btn-success','data-confirm'=>'Pesanan telah diterima pelanggan ?']) ?>
            </div>
        	<?php endif;?>
<?php ActiveForm::end(); ?>