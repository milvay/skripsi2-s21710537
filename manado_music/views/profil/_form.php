<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Profil */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profil-form">

    <?php $form = ActiveForm::begin(['id'=>'form-profil', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'tentang')->widget(CKEditor::className(), [
        'options' => ['rows' => 6,'placeholder'=>'Isi Deskripsi'],
        'preset' => 'basic',
        'clientOptions' => [
            'allowedContent' => true,
            'autoParagraph' => false
        ],
        //'inline' => false,
    ])->label() ?>

    <div class="form-group" style="text-align:center;">
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Simpan') : Yii::t('app', 'Simpan'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJs("
        $('form#form-profil').on('beforeSubmit',function (e) {
            var \$form = $(this);
            $.post(
                \$form.attr('action'),
                \$form.serialize()
            ).done(function(result){
                $(\$form).trigger('reset');
                $.pjax.reload({container:'#pjx-profil-index'});
            }).fail(function(){
                console.log('Server Error');
            });
            return false;
        });
    ");
?> 
