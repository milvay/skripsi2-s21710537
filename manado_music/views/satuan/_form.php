<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Satuan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="satuan-form col-lg-7" style="background-color:#dce3ed;padding:8px;"">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'satuan')->textInput(['placeholder' => 'Input Satuan (*)', 'maxlength'=>'15'])->label(false) ?>

    <?= $form->field($model, 'keterangan')->widget(CKEditor::className(), [
        'options' => ['rows' => 6,'placeholder'=>'Isi Keterangan'],
        'preset' => 'basic',
        'clientOptions' => [
	        'allowedContent' => true,
	        'autoParagraph' => false
	    ],
        //'inline' => false,
    ])->label() ?>

    <div class="form-group" style="text-align:center;">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
