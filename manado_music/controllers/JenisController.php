<?php

namespace app\controllers;

use Yii;
use app\models\Jenis;
use app\models\JenisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JenisController implements the CRUD actions for Jenis model.
 */
class JenisController extends Controller
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
     * Lists all Jenis models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;
        $this->layout="admin";
        $searchModel = new JenisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jenis model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;
        $this->layout="admin";
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Jenis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;
        $this->layout="admin";
        $model = new Jenis();

        if ($model->load(Yii::$app->request->post())):
            //$model->keterangan = $_POST['Jenis']['keterangan'];
            $model->keterangan = strip_tags($model->keterangan);
            if($model->save(false)):
                return $this->redirect(['/jenis/index']);
                echo 1;
            else:
                echo 0;
            endif;
        else:
            return $this->render('create', [
                'model' => $model,
            ]);
        endif;
    }

    /**
     * Updates an existing Jenis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;
        $this->layout="admin";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())):
            if($model->save(false)):
                return $this->redirect(['/jenis/index']);
                echo 1;
            else:
                echo 0;
            endif;
        else:
            return $this->render('update', [
                'model' => $model,
            ]);
        endif;
    }

    /**
     * Deletes an existing Jenis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Jenis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jenis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->isGuest):
            Yii::$app->user->logout();
            return $this->goHome();
        endif;
        if (($model = Jenis::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
