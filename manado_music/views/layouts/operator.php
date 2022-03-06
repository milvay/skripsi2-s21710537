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
$delTransaksi = $connection->createCommand("DELETE FROM transaksi WHERE status='Booking' AND tanggal_expired < '$now' OR status='Diproses' AND tanggal_expired < '$now'")->execute();
$delKonfirmasi = $connection->createCommand("DELETE FROM konfirmasi WHERE status='Booking1' AND tanggal_expired < '$now' OR status='Booking2' AND tanggal_expired < '$now'")->execute();

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

    <?= $this->render("//layouts/operator-main")?>

    <div class="fixed-sidebar">
        <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <li class="header">
                <span class="sidebar-header" style="color:#fff;font-weight:bold;"><?=Yii::t('app','MENU')?></span>
            </li>

            <li>
                <?=Html::a('<i class="fa fa-laptop text-aqua"></i> <span class="text-aqua">'.Yii::t('app','PEMESANAN').'</span>', 
                    Url::toRoute(['/operator/index-operator'])
                );?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-unlock text-red"></i> <span class="text-red">'.Yii::t('app','GANTI PASSWORD').'</span>', 
                    Url::toRoute(['/operator/change-password'])
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

                <strong><b>Nanofood Indonesia</b> &copy; 2020</strong>
                
        </footer>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>