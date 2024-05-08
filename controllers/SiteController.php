<?php

namespace app\controllers;

use app\models\Otp;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
                        'actions' => ['logout', 'forgot-password'],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        } else{
            return $this->render('index');
        }

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/site/login']);
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


    public function actionForgotPassword($email){
        if (!$email){
            $result["success"] = "O";
            $result["message"] = "Please Provide Email";
            return json_encode($result);
        }

        //check if user exists
        $user = Users::findOne(['email'=>$email]);

        if (!$user){
            $result["success"] = "O";
            $result["message"] = "Invalid Email provided";
            return json_encode($result);
        }

        $otp = rand(10000, 99999);
        $min = 30;
        $subject = 'Password Reset';
        $body = "<div style='border:1px dashed grey; padding:5px;  border-radius: 10px '>
                     <h3><b>Hi {$user->username}, </b></h3>
                     <p>Please use the OTP below to reset password. Otp will expire in {$min} mins. </p>
                     <h1 style='alignment: center'>{$otp}</h1>
                 
                     <p>Ignore this email if you have not initiated the request.</p>
              
                     Regards,<br/>
                     <b>Midlands Ltd Services.</b>         
                </div>
    ";
        $otpExpiryTime = $min * 60;
        $this->sendEmail($email, $subject, $body, []);
        $model = new Otp();
        $model->otp = $otp;
        $model->user_id = $user->id;
        $model->otp_expiry = $otpExpiryTime;

        if ($model->save(false)){
            $result["success"] = "1";
            $result["message"] = "OTP sent to your email!";
            $result["user_id"] = $user->id;
            return json_encode($result);
        }

        $result["success"] = "O";
        $result["message"] = "OTP could not be sent!";
        return json_encode($result);


    }

    public function actionVerifyOtp($userId, $otp){
        //check if user exists
        $otpModel = Otp::find()
            ->where(['user_id' => $userId, 'status' => 'ACTIVE'])
            ->orderBy('created_on DESC')
            ->one();

        if (!$otpModel){
            $result["success"] = "O";
            $result["message"] = "Invalid user id provided";
            return json_encode($result);
        }


        if ($otpModel->otp != $otp){
            $result["success"] = "O";
            $result["message"] = "Invalid OTP provided!";
            return json_encode($result);
        }


        $otpModel->status = 'USED';
        $otpModel->save(false);
        $result["success"] = "1";
        $result["message"] = "OTP verified successfully";
        return json_encode($result);

    }

    public function actionResetPassword($userId, $password){
        //check if user exists
        $user = Users::findOne($userId);

        if (!$user){
            $result["success"] = "0";
            $result["message"] = "User could not be found";
            return json_encode($result);
        }

        $user->password = md5($password);
        if ($user->save()){
            $result["success"] = "1";
            $result["message"] = "Password changed successfully!";
            $subject = 'Password Reset';
            $body = "<div style='border:1px dashed grey; padding:5px;  border-radius: 10px '>
                     <h3><b>Hi {$user->username}, </b></h3>
                     <p>Your password has been changed successfully. You can now log in with the new password!</p>
              
                     Regards,<br/>
                     <b>Midlands Ltd Services.</b>         
                </div>
    ";

            $this->sendEmail($user->email, $subject, $body, []);


        }
        else{
            $result["success"] = "0";
            $result["message"] = "An error occurred while processing request!";
        }
        return json_encode($result);

    }

    public function sendEmail($to,$subject,$body,$copied){
        Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom(['midlandscorp@gmail.com' => Yii::$app->name])
            ->setSubject($subject)
            ->setCc($copied)
            ->setHtmlBody($body)
            ->send();
    }
}
