<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title='Cek Pemesanan';

$this->registerJs("
    $('#sukses').delay(3000).fadeOut('slow');
");
?>
<div class='cek-pemesanan-index'>

        <?php if( Yii::$app->session->hasFlash('success') ):?>
            <div class="alert alert-success" id="sukses" style="bottom:0;position:fixed;">
                <?= Yii::$app->session->getFlash('success')?>
            </div>
        <?php elseif( Yii::$app->session->hasFlash('danger') ):?>
            <div class="alert alert-danger" id="sukses" style="bottom:0;position:fixed;">
                <?= Yii::$app->session->getFlash('danger')?>
            </div>
        <?php endif;?>

        <?php $form = ActiveForm::begin(['id'=>'form-search-site']); ?>

        <?= $form->field($model, 'search')->textInput([
                'maxlength'=>250,
                'placeholder'=>'Masukkan Kode Pesanan/ resi',
                'style' => 'float:left;clear:left;margin-top:-8px;width:80%;'
                //'class'=>'search-index-pesanan'
            ])->label(false) ?>
        <?= Html::submitButton(Yii::t('app', 'Cari'), ['class' => 'btn btn-success','style'=>'margin-top:-8px;']) ?>

        <?php ActiveForm::end(); ?>

</div>