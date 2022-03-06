<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\db\Query;
$connection = \Yii::$app->db;

/* @var $this yii\web\View */
/* @var $model app\models\Produk */
/* @var $form yii\widgets\ActiveForm */
$katSQL = $connection->createCommand("SELECT * FROM jenis WHERE aktivasi='Aktif' ORDER BY jenis ASC");
$satSQL = $connection->createCommand("SELECT * FROM satuan ORDER BY satuan ASC");
?>

<div class="produk-form" style="background-color:#dce3ed;padding:8px;">

  <?php $form = ActiveForm::begin(['id' => 'form-wilayah', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
      <div class="col-md-12">

        <div class="col-md-6">

        </div>
        <div class="col-md-6">
          <div class="form-group" style="text-align:right;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Simpan') : Yii::t('app', 'simpan'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
          </div>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'nama')->textInput(['maxlength'=>40,'placeholder'=>'Nama Produk(*)'])->label(false) ?>

          <?= $form->field($model, 'jenis')->dropDownList(ArrayHelper::map($katSQL->queryAll(),'id',
            function($model, $defaultValue){
                return $model['jenis'];
            }), [
            'prompt' => 'Pilih Kategori(*)',
          ])->label(false) ?>

          <?= $form->field($model, 'harga_jual')->textInput(['maxlength' => 15,'placeholder'=>"Harga Jual(*)"])->label(false) ?>
        </div>

        <div class="col-md-6">
          <?= $form->field($model, 'berat')->textInput(['type'=>'number','maxlength' => 15,'placeholder'=>'Berat dalam satuan gram(*)'])->label(false) ?>

          <?= $form->field($model, 'aktivasi')->dropDownList([ 
              'Aktif' => 'Aktif',
              'Tidak Aktif' => 'Tidak Aktif',
          ], ['prompt' => 'Aktivasi (*)'])->label(false) ?>
        </div>
        <!-- End col-6 -->
        
        <div class="col-md-12">
          <?= $form->field($model, 'deskripsi')->widget(CKEditor::className(), [
            'options' => ['rows' => 6,'placeholder'=>'Isi Deskripsi'],
            'preset' => 'basic',
            'clientOptions' => [
                'allowedContent' => true,
                'autoParagraph' => false
            ],
            //'inline' => false,
          ])->label() ?>
        </div>
        
        <div class="col-md-12">
          <?php Pjax::begin(['id'=>'gambar-photo', 'enablePushState' => false]); ?> 
              <?php 
                  if($bmodel != NULL):
                    foreach($bmodel as $m => $m2):?>
                      <div class="form-produk-foto">
                        
                      <?= Html::button(Yii::t('app', '<span class="fa fa-close" style="font-size:2.0em;"></span>'), [
                          'value' => Url::to(['delete-gambar','id'=>$m2->id]),
                          'onclick' => "
                              if(confirm('Apakah anda yakin untuk menghapus Gambar ?')){
                                  $.ajax({
                                      url: '".Url::to(['delete-gambar','id' => $m2->id])."',
                                      type: 'POST',
                                      success: function() {
                                          $.pjax.reload({container:'#gambar-photo'});
                                      }
                                  });
                              }
                              return false;
                          ",
                          'class' => 'ft-rm-form-produk'
                          //'class' => 'btn btn-danger', 'style' => "padding:1px;clear:left;margin:0 50px 0 0px;position:relative;float:left;"
                      ]);?>
                      <?php
                        $path = Yii::$app->request->baseUrl."/gambar/produk/".$m2->gambar;
                        $file_parts = pathinfo($path);
                        if($file_parts['extension'] == "mp4"):?>
                          <video class='ft-form-produk' controls>
                            <source src="<?=$path?>" type="video/mp4">
                          </video>
                      <?php else: ?>
                        <span class='ft-form-produk'>
                          <img src='<?php echo Yii::$app->request->baseUrl; ?>/gambar/produk/<?php echo $m2->gambar;?>'  class='ft-form-produk'>
                        </span>
                      <?php endif;?>
                      </div>
              <?php       
                    endforeach;
                  endif;
              ?>
            <?php Pjax::end();?>

            <div style="clear:left;"></div>

            <?=
              $form->field($model, 'gambar[]')->widget(FileInput::classname(), [
                'options' => ['id' => 'gambar','multiple' => true, 'accept' => ['image/*', 'video/*']],
                'pluginOptions' => [
                    'previewFileType' => ['image','text'],
                    'showUpload' => false,
                    'showRemove' => false,
                    'showCaption' => false,
                    'allowedFileExtensions' => ['jpg','jpeg','png','mp4'],
                    'maxFileSize'=>15360,
                    'maxFileCount' => 5,
                    'buttonLabelClass' => false,
                    'previewFileIcon' => '<i class="fa fa-photo"></i>',
                    'browseLabel' => 'Browse File',
                    //'allowedPreviewTypes' => null,
                    // 'previewFileIconSettings' => [
                    //         'doc' => '<i class="fa fa-file-word-o text-primary"></i>',
                    //         'docx' => '<i class="fa fa-file-word-o text-primary"></i>',
                    //         'xlsx' => '<i class="fa fa-file-excel-o text-success"></i>',
                    //         'xls' => '<i class="fa fa-file-excel-o text-success"></i>',
                    //         'pptx' => '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                    //         'ppt' => '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                    //         'pdf' => '<i class="fa fa-file-pdf-o text-danger"></i>',
                    // ]
                ]
              ])->label(false);
            ?>
        </div>
      </div>
      <!-- End col-12 -->
    </div>
    <!-- End row -->

    <?php ActiveForm::end(); ?>
</div>
