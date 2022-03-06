<?php

namespace app\controllers;

use Yii;

use yii\web\UploadedFile;
use yii\web\Controller;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\User;
use app\models\User2;
use app\models\UserSearch;
use app\models\Konfirmasi2;
use app\models\KonfirmasiSearch;
use app\models\ChangePass;

/**
 * AdminController implements the CRUD actions for User model.
 */
class OperatorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndexOperator()
    {
        $this->layout = "operator";
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->goHome();
        }
        $user = User::findOne(Yii::$app->user->id);
        if($user->level != 'operator'):
            Yii::$app->user->logout();
            return $this->goHome();   
        endif;

        $searchModel = new KonfirmasiSearch();
        $dataProvider = $searchModel->searchOperator(Yii::$app->request->queryParams);

        return $this->render('/operator/index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewTrx($id)
    {
        $this->layout = "operator";
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->goHome();
        }
        $user = User::findOne(Yii::$app->user->id);
        if($user->level != 'operator'):
            Yii::$app->user->logout();
            return $this->goHome();   
        endif;
        $model = Konfirmasi2::findOne($id);
        $connection = \Yii::$app->db;

        $cek2SQL = $connection->createCommand("SELECT * FROM konfirmasi WHERE no_transaksi='$model->no_transaksi' AND struk_bukti IS NOT NULL AND status='Diproses'")->queryOne();

        $cek2SQL_v = $connection->createCommand("SELECT * FROM konfirmasi WHERE no_transaksi='$model->no_transaksi' AND struk_bukti IS NOT NULL AND status='Verifikasi'")->queryOne();

        $cek2SQL_s = $connection->createCommand("SELECT * FROM konfirmasi WHERE no_transaksi='$model->no_transaksi' AND struk_bukti IS NOT NULL AND status='Pengantaran'")->queryOne();

        if ($model->load(Yii::$app->request->post())):
            if($cek2SQL):
                $model->status = 'Verifikasi';
                $sql = $connection->createCommand("UPDATE transaksi SET tanggal_expired='$model->tanggal_expired',status='Verifikasi',no_transaksi='$model->no_transaksi',nama_pelanggan='$model->nama_pelanggan',no_telepon='$model->no_telepon', no_resi='$model->no_resi' WHERE ip='$model->ip' AND status='Diproses'");   
                $sql->execute();
            elseif($cek2SQL_v):
                $model->status = 'Pengantaran';
                $sql = $connection->createCommand("UPDATE transaksi SET tanggal_expired='$model->tanggal_expired',status='Pengantaran',no_transaksi='$model->no_transaksi',nama_pelanggan='$model->nama_pelanggan',no_telepon='$model->no_telepon' WHERE ip='$model->ip' AND status='Verifikasi'");   
            elseif($cek2SQL_s):
                $model->status = 'Selesai';
                $sql = $connection->createCommand("UPDATE transaksi SET tanggal_expired='$model->tanggal_expired',status='Selesai',no_transaksi='$model->no_transaksi',nama_pelanggan='$model->nama_pelanggan',no_telepon='$model->no_telepon' WHERE ip='$model->ip' AND status='Pengantaran'");
            endif;
            $model->save();
            return $this->redirect(['index-operator']);
        endif;
        return $this->render('view-transaksi',[
            'model'=>$model,
            'cek2SQL' => $cek2SQL,
            'cek2SQL_v' => $cek2SQL_v,
            'cek2SQL_s' => $cek2SQL_s
        ]);
    }

    public function actionChangePassword()
    {
        $this->layout="operator";
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->goHome();
        }
        $user = User::findOne(Yii::$app->user->id);
        if($user->level != 'operator'):
            Yii::$app->user->logout();
            return $this->goHome();   
        endif;

        $model = new ChangePass();
        if ($model->load(Yii::$app->request->post())):
            if($user->password == sha1($model->old) && $model->new == $model->confirm):
                $user->password = sha1($model->new);
                $user->save();
                Yii::$app->session->setFlash('success', "<span class='glyphicon glyphicon-ok'></span> Password Berhasil di atur ulang.");
                Yii::$app->session->setFlash('success', "<span class='glyphicon glyphicon-ok'></span> Password Berhasil di ganti.");
                return $this->redirect(['change-password']);
            else:
                Yii::$app->session->setFlash('danger', "<span class='glyphicon glyphicon-remove'></span> Gagal Mengganti Password, silahkan di coba lagi.");
                return $this->redirect(['change-password']);
            endif;
        endif;

        return $this->render('/site/change-password',[
            'model' => $model,
        ]);
    }
}