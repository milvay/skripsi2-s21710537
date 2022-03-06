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
use app\models\ChangePass;

/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller
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

    public function actionIndexAdmin()
    {
        $this->layout = "admin";
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->goHome();
        }
        $user = User::findOne(Yii::$app->user->id);
        if($user->level != 'admin'):
            Yii::$app->user->logout();
            return $this->goHome();   
        endif;

        return $this->render('/admin/index',[
            'user' => $user,
        ]);
    }

    public function actionChangePassword()
    {
        $this->layout="admin";
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->goHome();
        }
        $user = User::findOne(Yii::$app->user->id);
        if($user->level != 'admin'):
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
