<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\ProdukGambar;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */

$this->title = 'Manado Music';

$this->registerJs("
    $('#sukses').delay(3000).fadeOut('slow');
");

$ip = Yii::$app->getRequest()->getUserIP();
?>

<?php if( Yii::$app->session->hasFlash('success') ):?>
    <div class="alert alert-success" id="sukses" style="bottom:0;position:fixed;">
        <?= Yii::$app->session->getFlash('success')?>
    </div>
<?php elseif( Yii::$app->session->hasFlash('danger') ):?>
    <div class="alert alert-danger" id="sukses" style="bottom:0;position:fixed;">
        <?= Yii::$app->session->getFlash('danger')?>
    </div>
<?php endif;?>
<div class="site-index">
    <div class='pag-index-site'>
        <?=LinkPager::widget([
            'pagination' => $pagination,
            'maxButtonCount'=>false,
            //'lastPageLabel' => 'Last',
            'nextPageLabel' => 'Next',
            'prevPageLabel' => 'Prev',
        ])?>
    </div>

    <div class="col-md-12" id="filter-barang">
        <?php $form = ActiveForm::begin(['id'=>'form-search-site']); ?>

        <div class="col-md-4">
          <div class="col-md-12">
            <?= $form->field($model2, 'search')->textInput([
              'placeholder'=>'Cari...',
              'class'=>'form-control',
              // 'style' => "float:left;"
            ], 
            [
              'onclick'=>"
                $.ajax({
                    url: '".Url::to(['index'])."',
                    type: 'POST',
                    success: function() {
                        $.pjax.reload({container:'#pjax-site-produk', async:false});
                    }
                });",
              'class'=>'form-control'
            ]
            )->label(false) ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="col-md-6">
            <?= $form->field($model2, 'min')->textInput(['maxlength' => 10,'placeholder'=>'Min'])->label(false) ?>
          </div>
          <div class="col-md-6">
            <?= $form->field($model2, 'max')->textInput(['maxlength' => 10,'placeholder'=>'Max'])->label(false) ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="col-md-8">
            <?= $form->field($model2, 'filterSelect')->dropDownList([ 
                'terbaru' => 'Data Terbaru',
                'terlama' => 'Data Terlama',
                'termurah' => 'Harga Termurah',
                'termahal' => 'Harga Termahal',
                'namaatoz' => 'A to Z',
                'namaztoa' => 'Z to A',
            ], ['prompt' => 'Sorting'])->label(false) ?>
          </div>
          <div class="col-md-4" style="text-align:right;">
            <?= Html::submitButton(Yii::t('app', '<span class="fa fa-search" style="font-size:15px;padding:4px;padding-bottom:8px;padding-top:5px;"></span>')) ?>
          </div>
        </div>
      <?php ActiveForm::end(); ?>
    </div>

    <?php Pjax::begin(['id'=>'pjax-site-produk','enablePushState'=>false]); ?>    
    <ul class='ul-produk'>
    <?php foreach($model as $m => $md):?>
        <li>
            <a target="_blank" href="<?=Url::to(['view-produk','id'=>$md->id])?>">
            <?php $model2 = ProdukGambar::find()->where("produk='$md->id'")->orderby("rand()")->one();?>
            <?php if($model2 != null):
              $path = Yii::$app->request->baseUrl."/gambar/produk/".$model2->gambar;
              $file_parts = pathinfo($path);
              if($file_parts['extension'] == "mp4"):?>
                <video  class='ft-site-produk'>
                  <source src="<?=$path?>" type="video/mp4">
                </video>
            <?php else:?>
                <img src='<?php echo Yii::$app->request->baseUrl; ?>/gambar/produk/<?= $model2->gambar;?>' class='ft-site-produk'>
              <?php endif;?>
            <?php else:?>
                <span class='fa fa-image ft-site-produk size-produk'></span>
            <?php endif;?>
            </a>
            <div class="view-desc-produk">
              <a href="<?=Url::to(['view-produk','id'=>$md->id])?>">
              <p><span class='head-produk'><?=Html::encode("{$md->nama}")?></span></p>
              <p class="harga-produk">Rp <span style="text-align:right;"><?=number_format($md->harga_jual,0,',','.').",00"?></span></p>
              </a>
            </div>
            <?php
              $kategori = (new yii\db\Query())
              ->from('jenis')
              ->where("id='$md->jenis'")
              ->one();
              $sendText = "*".$kategori['jenis'].": ".$md->nama."*%0aHai kak, barang ini ready yah?";
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
            <span class="btn btn-success" id="wa-cek-barang">
              <a href="https://wa.me/<?=$kontak?>?text=<?=$sendText?>" target="_blank"><i class="fa fa-whatsapp"></i> Cek barang</a>
            </span>
        </li>
    <?php endforeach;?>
    </ul>
    <?php Pjax::end(); ?>

    <div style="clear:left;"></div>
</div>
