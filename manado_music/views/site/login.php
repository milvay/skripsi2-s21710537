<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="site-login">
    <div class="login-box" style="margin-top:-20px;">
        <div class="login-logo wow tada" data-wow-iteration="infinite" data-wow-duration="1800ms">
        </div>
        <div class="login-box-body">

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username', 
                        [
                            'inputOptions' => ['autocomplete' => 'off'],
                            'options' => [
                                'tag' => 'div',
                                'class' => 'form-group field-login-loginform-username has-feedback required'
                        ],
                        'template' => '{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        {error}{hint}'
                    ])->textInput(['placeholder' => 'Akun Pengguna']) ?>

                <?= $form->field($model, 'password', [
                        'inputOptions' => ['autocomplete' => 'off'],
                        'options' => [
                            'tag' => 'div',
                            'class' => 'form-group field-login-loginform-password has-feedback required'
                        ],
                        'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        {error}{hint}'
                    ])->passwordInput(['placeholder' => 'Kata Sandi']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox()?>

                <div class="form-group">
                        <?= Html::submitButton('Login', [
                            'class' => 'btn btn-success',
                            'name' => 'login-button',
                            'style' => "width:100%;",
                        ]) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
