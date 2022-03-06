<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Jenis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jenis-form col-lg-7" style="background-color:#dce3ed;padding:8px;"">

    <?php $form = ActiveForm::begin(['id' => 'form-kategori', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'jenis')->textInput(['maxlength' => 30, 'placeholder'=>'Nama Kategori (*)'])->label(false) ?>

        <?= $form->field($model, 'keterangan')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic',
            'clientOptions' => [
    	        'allowedContent' => true,
    	        'autoParagraph' => false
    	    ],
            //'inline' => false,
        ])->label() ?>

        <?= $form->field($model, 'aktivasi')->dropDownList([ 
            'Aktif' => 'Aktif',
            'Tidak Aktif' => 'Tidak Aktif',
        ], ['prompt' => 'Aktivasi (*)'])->label(false) ?>

    <div class="form-group" style="text-align:center;">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    // $this->registerJs("
    //     $('form#form-kategori').on('beforeSubmit',function (e) {
    //         var \$form = $(this);
    //         $.post(
    //             \$form.attr('action'),
    //             \$form.serialize()
    //         ).done(function(result){
    //             $(\$form).trigger('reset');
    //             $.pjax.reload({container:'#kategoriGrid'});
    //         }).fail(function(){
    //             console.log('Server Error');
    //         });
    //         return false;
    //     });
    // ");
?> 
