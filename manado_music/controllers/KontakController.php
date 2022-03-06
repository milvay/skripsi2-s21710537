<?php

namespace app\controllers;

use Yii;
use app\models\Kontak;
use app\models\KontakSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KontakController implements the CRUD actions for Kontak model.
 */
class KontakController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Kontak models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "admin";
        $searchModel = new KontakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kontak model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = "admin";
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kontak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "admin";
        $model = new Kontak();

        if ($model->load(Yii::$app->request->post())) {
            $kontak = $_POST['Kontak']['kontak'];
            $jenis_kontak = "<span class='fa fa-whatsapp'> Whatsapp</span>";
            if(substr($kontak, 0,1) == '0' && $_POST['Kontak']['jenis_kontak'] == $jenis_kontak){
                $kontak = "62".substr($kontak,1);
            }elseif(substr($kontak, 0,1) == '+' && $_POST['Kontak']['jenis_kontak'] == $jenis_kontak){
                $kontak = substr($kontak,1);
            }
            $model->kontak = $kontak;
            if($model->save()):
                echo 1;
            else:
                echo 0;
            endif;
        } else {
            if(Yii::$app->request->isAjax):
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            else:
                return $this->render('create', [
                    'model' => $model,
                ]);
            endif;
        }
    }

    /**
     * Updates an existing Kontak model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "admin";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()):
                Yii::$app->session->setFlash('success', "<span class='fa fa-close'></span> Berhasil di update.");
                return $this->redirect(['index']);
            else:
                echo 0;
            endif;
        } else {
            if(Yii::$app->request->isAjax):
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            else:
                return $this->render('update', [
                    'model' => $model,
                ]);
            endif;
        }
    }

    /**
     * Deletes an existing Kontak model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kontak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kontak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kontak::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
