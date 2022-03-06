<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SearchPForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Produk;
use app\models\ProdukSearch;
use app\models\ProdukGambar;
use app\models\ProdukGambarSearch;
use yii\db\Query;
use yii\db\Expression;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\httpclient\Client;
use yii\widgets\ActiveForm;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionBantuan()
    {
        return $this->render('bantuan');
    }

    public function actionViewProduk($id)
    {
        if (!Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;

        return $this->render('view-produk',[
            'model' => $model=Produk::findOne($id),
            'gambar' => ProdukGambar::find()->where("produk='$model->id'")->all(),
        ]);
    }

    public function actionSideKategori($id)
    {
        if (!Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;

        $model2 = new SearchPForm();

        $query = Produk::find()->where("jenis='$id'");
        if($model2->load(Yii::$app->request->post())):
            $search = $_POST['SearchPForm']['search'];

            $pagination = new Pagination([
                'defaultPageSize' => 12,
                'totalCount' => $query->count(),
            ]);
            if($search != '' || $search != NULL):
                $model = $query->orderBy('nama ASC')
                    ->andFilterWhere(['like', 'nama', $search])
                    ->andFilterWhere(['jenis'=> $id])
                    ->andFilterWhere(['like', 'deskripsi', $search])
                    //->offset($pagination->offset)
                    ->all();
                if($model == NULL):
                    Yii::$app->session->setFlash('danger', "<span class='fa fa-close'></span> Data tidak ditemukan.");
                    return $this->refresh();
                endif;
            else:
                return $this->refresh();
            endif;
        else:
            $pagination = new Pagination([
                'defaultPageSize' => 12,
                'totalCount' => $query->count(),
            ]);
            $model = $query->orderBy('nama ASC')
                    ->andFilterWhere(['jenis'=> $id])
                    //->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
        endif;

        return $this->render('index',[
            'model' => $model,
            'pagination' => $pagination,
            'model2' => $model2
        ]);
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;
        
        $model2 = new SearchPForm();

        if($model2->load(Yii::$app->request->post())):
            $search = $_POST['SearchPForm']['search'];
            
            $min = 0;
            $max = 9999999999999;
            
            $postSort = $_POST['SearchPForm']['filterSelect'];
            if($postSort == "terbaru"):
              $sort = "id DESC";
            elseif($postSort == "terlama"):
              $sort = "id ASC";
            elseif($postSort == "termurah"):
              $sort = "harga_jual ASC";
            elseif($postSort == "termahal"):
              $sort = "harga_jual DESC";
            elseif($postSort == "namaatoz"):
              $sort = "nama ASC";
            elseif($postSort == "namaztoa"):
              $sort = "nama DESC";
            else:
              $sort = "id DESC";
            endif;

            $filterMin = isset($_POST['SearchPForm']['min']) ? $_POST['SearchPForm']['min'] : $min;
            $filterMax = isset($_POST['SearchPForm']['max']) ? $_POST['SearchPForm']['max'] : $max;
            $filterSort = 
            $query = Produk::find();

            $pagination = new Pagination([
                'defaultPageSize' => 12,
                'totalCount' => $query->count(),
            ]);
            if($search != '' || $search != NULL):
                $model = $query->orderBy("$sort")
                  ->andFilterWhere(['like', 'nama', $search])
                  ->andFilterWhere(['>=', 'harga_Jual',$filterMin])
                  ->andFilterWhere(['<=', 'harga_Jual',$filterMax])
                  ->orFilterWhere(['like', 'deskripsi', $search])
                  ->andFilterWhere(['>=', 'harga_Jual',$filterMin])
                  ->andFilterWhere(['<=', 'harga_Jual',$filterMax])
                  //->offset($pagination->offset)
                  ->all();
                if($model == NULL):
                    Yii::$app->session->setFlash('danger', "<span class='fa fa-close'></span> Data tidak ditemukan.");
                    return $this->refresh();
                endif;
            else:
              $model = $query->andFilterWhere(['>=','harga_jual',$filterMin])
              ->andFilterWhere(['<=','harga_jual',$filterMax])
              ->orderBy("$sort")
              //->offset($pagination->offset)
              ->all();
            // return $this->refresh();
            endif;
        else:
            $query = Produk::find();
            $pagination = new Pagination([
                'defaultPageSize' => 12,
                'totalCount' => $query->count(),
            ]);
            $model = $query->orderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        endif;

        return $this->render('index',[
            'model' => $model,
            'pagination' => $pagination,
            'model2' => $model2
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLoginAdm()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()):
            $user = User::findOne(['username'=>$model->username]);
            if($user->level=='admin'):
                return $this->redirect(['/admin/index-admin']);
            elseif($user->level=='operator'):
                return $this->redirect(['/operator/index-operator']);
            else:
                return $this->goHome();
            endif;
        else:
            return $this->render('login', [
                'model' => $model,
            ]);
        endif;
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
