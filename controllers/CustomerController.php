<?php

namespace app\controllers;

use app\models\User;
use app\models\Users;
use Yii;
use app\models\Customer;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            $searchModel = new CustomerSearch();
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
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->isGuest){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        else{
            return $this->redirect(['/site/login']);
        }

    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest){
            $model = new Customer();
            $modelUser = new Users();

            if ($model->load(Yii::$app->request->post())&& $model->save() ) {
                $modelUser->username = $model->fname.' '.$model->sname;
                $modelUser->email = $model->email;
                $modelUser->user_type = 'customer';
                $modelUser->status = 'active';
                $modelUser->password = md5('12345');
                if ($modelUser->save() ){
                    Yii::$app->session->setFlash('success',"New Customer Registered Successfully!");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->session->setFlash('error',"Sorry! Could not register new customer!");
                }
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
        else{
            return $this->redirect(['/site/login']);
        }

    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->isGuest){
            $model = $this->findModel($id);
            $modelUser = Users::findOne(['email'=>$model->email]);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if ($modelUser!=null){
                    $modelUser->username = $model->fname.' '.$model->sname;
                    $modelUser->email = $model->email;
                    $modelUser->user_type = 'customer';

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
     * Deletes an existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
