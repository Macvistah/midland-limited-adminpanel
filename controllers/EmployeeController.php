<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use app\models\Employee;
use app\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            $searchModel = new EmployeeSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            return $this->redirect(['/site/login']);
        }

    }

    /**
     * Displays a single Employee model.
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
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest){
            $model = new Employee();
            $modelUser = new Users();

            if ($model->load(Yii::$app->request->post())&& $model->save()) {
                $modelUser->username = $model->fname.' '.$model->sname;
                $modelUser->email = $model->email;
                $modelUser->user_type = $model->role;
                $modelUser->status = 'active';
                $modelUser->password = md5('12345');
                if ($modelUser->save() ){
                    Yii::$app->session->setFlash('success',"New Staff Registered Successfully!");
                }
                else{
                    Yii::$app->session->setFlash('error',"Sorry! Could not register new staff!");
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
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->isGuest){
            $model = $this->findModel($id);
            $modelUser = Users::findOne(['email'=>$model->email]);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if ($modelUser!=null){
                    $modelUser->username = $model->fname.' '.$model->sname;
                    $modelUser->email = $model->email;
                    $modelUser->user_type = $model->role;

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
        }else{
            return $this->redirect(['/site/login']);
        }

    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelUser = Users::findOne(['email'=>$model->email]);
        if($model->delete()) {
            if ($modelUser != null) {
                $modelUser->delete();
            }
            Yii::$app->session->setFlash('success',"Record deleted successfully");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
