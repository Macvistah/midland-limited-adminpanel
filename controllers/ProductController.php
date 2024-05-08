<?php

namespace app\controllers;

use app\models\ProductCategory;
use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {

            $searchModel = new ProductSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);


    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

            $model = new Product();

            if ($model->load(Yii::$app->request->post())) {
                if (UploadedFile::getInstance($model, 'file')!='')
                {
                    $model->file = UploadedFile::getInstance($model, 'file');
                    $image_name = rand()."_".time(). '.' .$model->file->extension;
                    $model->file->saveAs('uploads/product_images/' .$image_name);
                    $model->image =$image_name;

                }
                if ($model->save()){
                    Yii::$app->session->setFlash('success',"New Product Created Successfully!");
                    return $this->redirect(['view', 'id' => $model->prod_id]);
                }else{
                    Yii::$app->session->setFlash('error',"Failed! Could Not create product");
                }
            }

            return $this->render('create', [
                'model' => $model,
            ]);


    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                if (UploadedFile::getInstance($model, 'file')!='')
                {
                    $model->file = UploadedFile::getInstance($model, 'file');
                    $image_name = rand()."_".time(). '.' .$model->file->extension;
                    $model->file->saveAs('uploads/product_images/' .$image_name);
                    $model->image =$image_name;

                }
                if ($model->save()){
                    Yii::$app->session->setFlash('success',"Details Updated Successfully!");
                    return $this->redirect(['view', 'id' => $model->prod_id]);
                }else{
                    Yii::$app->session->setFlash('error',"Failed! Could Not update details");
                }
            }

            return $this->render('update', [
                'model' => $model,
            ]);


    }

    public function actionCategory(){

            $model = new ProductCategory();
            if($model->load(Yii::$app->request->post())){
                if ($model->save()){
                    Yii::$app->session->setFlash('success',"Product Category created successfully!");
                }
                else{
                    Yii::$app->session->setFlash('error',"Failed! Could not create category");
                }
            }
            $this->redirect(['index']);


    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
