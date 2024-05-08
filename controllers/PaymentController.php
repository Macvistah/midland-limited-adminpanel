<?php

namespace app\controllers;

use app\models\Order;
use Yii;
use app\models\Payment;
use app\models\PaymentSearch;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
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
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payment model.
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
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payment();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->payment_account == 'Order') {
                $modelOrder = Order::findOne(['id' => $model->account_no]);
                $model->amount = $modelOrder->total_amount;
                $model->transaction_no = strtoupper(substr("CPM", 0, 4)) . date("ym") . rand(pow(10, 3), pow(10, 2));
                if ($model->save(false) ) {
                    $modelOrder->payment_id = $model->transaction_no;
                    $modelOrder->save(false);
                    Yii::$app->session->setFlash('success', 'Record created successfully!');
                    return $this->redirect(['view', 'id' => $model->payment_id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Record could not be created!');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payment_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public  function actionAccount(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $account = $parents[0];
                $out = self::getAccountNo($account);

                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionAmount() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $account_type = empty($ids[0]) ? null : $ids[0];
            $account_no = empty($ids[1]) ? null : $ids[1];
            if ($account_type != null) {
                $data = self::getAmount($account_type, $account_no);
                return ['output'=>$data['out'], 'selected'=>$data['selected']];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function getAccountNo($account){
        $out = [];
        if ($account =='Order'){
            $models = Order::findAll(['payment_id'=>null]);
            foreach ($models as $model){
                $out [] = ['id'=>$model->id,'name'=>$model->order_no];
            }
        }
        return $out;
    }
    public function getAmount($account_type,$account_no){
        $out = [];

        if ($account_type =='Order'){
            $model = Order::findOne(['id'=>$account_no]);
            $out = [
                'out'=>[
                    ['id'=>$model->total_amount,'name'=>$model->total_amount],
                 ],
                'selected'=>$model->total_amount,
                ];
        }
        return $out;
    }

    /**
     * Deletes an existing Payment model.
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
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
