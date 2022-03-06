<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use kartik\nav\NavX;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\MainAsset;
use yii\bootstrap\Modal;
use yii\helpers\Url;

MainAsset::register($this);
?>

    <header class="main-header">
        <nav class="navbar-fixed-top">
          <!-- Sidebar toggle button-->
            <!-- Logo -->
            <div class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini" style="font-size:0.7em;margin-top:-10px;">
                <b>MM</b>
              </span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg" style="font-size:0.95em;"><b>MANADO MUSIC</b>
              </span>
            </div>

            <?php
            NavBar::begin([
                'brandLabel' => "
                  <a href='javascript:void(0);' style='margin-left:-30px;' class='sidebar-toggle' data-toggle='offcanvas'>
                    <span class='sr-only'>Toggle navigation</span>
                  </a>",
                'brandUrl' => false,
                'options' => [
                    'class' => 'navbar-inverse',
                ],
            ]);
            $menuItems = [
                // [
                //      'label' => "<i class='fa fa-user'></i> <span>".Yii::t('app', 'PRODUK')."</span>",
                //      'activateParents' => true,
                //      'encodeLabels ' => false,
                //      'items' => $itemsKategori,
                // ],
                // ['label' => "<i class='fa fa-shopping-bag' style='font-size:1.3em;'></i> TRANSAKSI", 'url' => ['/admin/index-admin']],
                // ['label' => "<i class='fa fa-list-alt' style='font-size:1.3em;'></i> REPORT", 'url' => ['/admin/report-admin']],
                Yii::$app->user->isGuest ? (
                    ['label' => 'LOGIN', 'url' => ['/site/login'], 'linkOptions'=>['id'=>'modalPassword']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                    . Html::submitButton(
                        '<i class="fa fa-sign-out"></i> LOGOUT (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link','style' => 'color:#fff;']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ];
            echo NavX::widget([
                'options' => ['class' => 'nav navbar-nav'],
                'items' => $menuItems,
                'activateParents' => true,
                'encodeLabels' => false
            ]);
            NavBar::end();
            ?>
        </nav>
    </header>