<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use kartik\nav\NavX;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$connection = \Yii::$app->db;
$now = date('Y-m-d H:i:s');

AppAsset::register($this);

//$kategori = $connection->createCommand('SELECT * FROM jenis ORDER BY jenis ASC');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
   <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/gambar/rj-icon.gif" type='image/x-icon' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-green sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

  <?= $this->render("//layouts/admin-main")?>

  <div class="fixed-sidebar">
    <aside class="main-sidebar">
      <section class="sidebar">
        <ul class="sidebar-menu">
          <li class="header">
            <span class="sidebar-header" style="color:#fff;font-weight:bold;"><?=Yii::t('app','PENGATURAN')?></span>
          </li>

          <li>
            <?=Html::a('<i class="fa fa-database text-green"></i> <span class="text-green">'.Yii::t('app','KATEGORI').'</span>', 
              Url::toRoute(['/jenis/index'])
            );?>
          </li>
          <li>
            <?=Html::a('<i class="fa fa-laptop text-aqua"></i> <span class="text-aqua">'.Yii::t('app','PRODUK').'</span>', 
              Url::toRoute(['/produk/index'])
            );?>
          </li>
          <li>
            <?=Html::a('<i class="fa fa-cc text-yellow"></i> <span class="text-yellow">'.Yii::t('app','KONTAK').'</span>', 
              Url::toRoute(['/kontak/index'])
            );?>
          </li>
          <li>
            <?=Html::a('<i class="fa fa-building text-white"></i> <span class="text-white">'.Yii::t('app','PROFIL').'</span>', 
              Url::toRoute(['/profil/index'])
            );?>
          </li>
          <li>
            <?=Html::a('<i class="fa fa-lock text-red"></i> <span class="text-red">'.Yii::t('app','GANTI PASSWORD').'</span>', 
              Url::toRoute(['/admin/change-password'])
            );?>
          </li>

        </ul>
      </section>
    </aside>
  </div>

  <div class="content-wrapper">
      <div class="my-content">
          <?= $content ?>
      </div>
  </div>
  <div id="footer">
      <footer class="main-footer">

              <strong><b>MANADO MUSIC</b> &copy; 2021</strong>
              
      </footer>
  </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>