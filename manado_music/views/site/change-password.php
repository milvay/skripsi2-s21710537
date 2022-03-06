<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title="Ganti Password";

$this->registerJs("
    $('#sukses').delay(3000).fadeOut('slow');
");

?>
<?php if( Yii::$app->session->hasFlash('success') ):?>
    <div class="alert alert-success" id="sukses" style="bottom:50px;position:fixed;">
        <?= Yii::$app->session->getFlash('success')?>
    </div>
<?php elseif( Yii::$app->session->hasFlash('danger') ):?>
    <div class="alert alert-danger" id="sukses" style="bottom:50px;position:fixed;">
        <?= Yii::$app->session->getFlash('danger')?>
    </div>
<?php endif;?>

<div class="change-password">

    <div class="login-box">
        <div class="login-box-body">
            <?php $form = ActiveForm::begin([
                'id' => 'password-form',
                //'options' => ['class' => 'form-horizontal'],
                /*'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-3 control-label'],
                ],*/
            ]); ?>

                <?= $form->field($model, 'old')->passwordInput(['placeholder'=>'Kata Sandi Lama']) ?>

                <?= $form->field($model, 'new')->passwordInput(['placeholder'=>'Kata Sandi Baru']) ?>

                <?= $form->field($model, 'confirm')->passwordInput(['placeholder'=>'Kata Sandi Baru']) ?>

                <?= Html::submitButton('Submit', [
                    'class' => 'btn btn-success', 
                    'name' => 'change-password-button'
                ]) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
