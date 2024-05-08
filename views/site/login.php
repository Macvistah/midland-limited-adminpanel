<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@web/images');

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" >
    <div class="col-md-4 col-sm-8 ml-auto mr-auto"><!-- col-lg-4  -->
        <div class="card card-login card-hidden " style="border-radius: 20px; opacity: 0.8 " >

            <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldConfig' => [
                        'template' => "{input}\n{hint}\n{error}",
                    ],
                ]); ?>
            <div class="card-body  ">
                <div class="row">
                    <div class="col-md-12 text-center mt-2 mb-2">
                        <div class="logo"><img src="../web/images/midland.png" style="max-width: 100px;">
                            <h4 class="card-title"><?=Yii::$app->name?></h4>
                    </div>
                    <div class="col-md-12">
                        <h6 class="text-center"> SIGN IN</h6>
                        <span class="bmd-form-group">
                        <?= $form->field($model, 'email',['template'=>'
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="material-icons">email</i>
                                </span>
                            </div>
                            {input}
                            {error}
                           
                        </div>',
                        ])->textInput(["class"=>"form-control","placeholder"=>"Email Address",'required'=>true])->label(false) ?>
                </span>
                        <span class="bmd-form-group">
                        <?= $form->field($model, 'password',['template'=>'
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="material-icons">lock_outline</i>
                                </span>
                            </div>
                            {input}
                            {error}
                        </div>
                        '
                        ])->passwordInput(["class"=>"form-control","placeholder"=>"Password",'required'=>true]) ?>
                </span>
                        <span class="bmd-form-group">
                    <div class="input-group ml-3">
                        <?= $form->field($model, 'rememberMe')->checkbox()?>
                    </div>
                </span>
                        <div class="card-footer justify-content-center">
                            <?= Html::a('<span class="text-black">Forgot Password?</span>','#',['class' => 'btn btn-outline-info btn-border', 'name' => 'forgot-button']) ?>
                            <?= Html::submitButton('Login', ['class' => 'btn btn-info btn-border', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                </div>

            </div>

           <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
