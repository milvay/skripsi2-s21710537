<?php

namespace app\controllers;

use Yii;
use app\models\Profil;
use app\models\ProfilSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfilController implements the CRUD actions for Profil model.
 */
class ProfilController extends Controller
{
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

    public function actionIndex()
    {
        $this->layout="admin";
        $searchModel = new ProfilSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $this->layout="admin";
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $this->layout="admin";
        $model = new Profil();

        if ($model->load(Yii::$app->request->post())) {
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

    public function actionUpdate($id)
    {
        $this->layout="admin";
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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Profil::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
