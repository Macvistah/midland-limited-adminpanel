<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use app\models\Supplier;
use app\models\SupplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Supplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Supplier model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest){
            $model = new Supplier();
            $modelUser = new Users();

            if ($model->load(Yii::$app->request->post())&& $model->save()) {
                $modelUser->username = $model->contact_fname.' '.$model->contact_sname;
                $modelUser->email = $model->contact_email;
                $modelUser->user_type = 'supplier' ;
                $modelUser->status = 'active';
                $modelUser->password = md5('12345');
                if ($modelUser->save() ){
                    Yii::$app->session->setFlash('success',"New Supplier Successfully!");
                }
                else{
                    Yii::$app->session->setFlash('error',"Sorry! Could not register new supplier!");
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else{
            return $this->redirect(['/site/login']);
        }
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->isGuest){
            $model = $this->findModel($id);
            $modelUser = Users::findOne(['email'=>$model->contact_email]);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if ($modelUser!=null){
                    $modelUser->username = $model->contact_fname.' '.$model->contact_sname;
                    $modelUser->email = $model->contact_email;
                    if ($modelUser->save(false) ){
                        Yii::$app->session->setFlash('success',"Data updated Successfully!");
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    else{
                        Yii::$app->session->setFlash('error',"Sorry! Could not update data!");
                    }
                }

            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        else{
            return $this->redirect(['/site/login']);
        }

    }

    /**
     * Deletes an existing Supplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
