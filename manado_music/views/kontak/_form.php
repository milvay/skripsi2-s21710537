<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kontak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kontak-form">

    <?php $form = ActiveForm::begin(['id'=>'form-kontak', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'jenis_kontak')->dropDownList([ 
        "<span class='fa fa-envelope-o'> Email</span>" => 'Email',
        "<span class='fa fa-facebook'> Facebook</span>" => 'Facebook',
        "<span class='fa fa-instagram'> Instagram</span>" => 'Instagram',
        "<span class='fa fa-mobile-phone'> Nomor Telepon/HP</span>" => 'Nomor Telepon/HP',
        "<span class='fa fa-whatsapp'> Whatsapp</span>" => 'Whatsapp',
        "<span class='fa fa-twitter'> Twitter</span>" => 'Twitter'
    ], ['prompt' => 'Pilih Jenis Kontak (*)'])->label(false) ?>

    <?= $form->field($model, 'kontak')->textInput(['placeholder' => 'Kontak...'])->label(false) ?>

    <?= $form->field($model, 'aktivasi')->dropDownList([ 
        'Aktif' => 'Aktif',
        'Tidak Aktif' => 'Tidak Aktif',
    ], ['prompt' => 'Aktivasi (*)'])->label(false) ?>

    <div class="form-group" style="text-align:center;">
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJs("
        $('form#form-kontak').on('beforeSubmit',function (e) {
            var \$form = $(this);
            $.post(
                \$form.attr('action'),
                \$form.serialize()
            ).done(function(result){
                $(\$form).trigger('reset');
                $.pjax.reload({container:'#pjx-kontak-index'});
            }).fail(function(){
                console.log('Server Error');
            });
            return false;
        });
    ");
?> 
