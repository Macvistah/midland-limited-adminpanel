<?php

use kartik\depdrop\DepDrop;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */
if (!$model->isNewRecord){
    $title = 'Edit Payment Record';
}
else{
    $title = 'Create New Payment Record';
}
?>

<div class="payment-form">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title"><?= $title ?></h4>
                    <p class="card-category">Fill all the fields</p>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Payment Account</label>
                                <?= $form->field($model, 'payment_account')->dropDownList(['Order'=>'Order Account','Service'=>'Service Account'],
                                    [
                                        'prompt'=>'Choose Account',
                                        'class'=>'form-control'
                                    ]
                                )->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Order/Service Number</label>
                                <?= $form->field($model, 'account_no')->widget(DepDrop::classname(), [
                                        'options'=>[],
                                        'pluginOptions'=>[
                                                'depends'=>['payment-payment_account'],
                                                'placeholder'=>'Select...',
                                                'url'=>Url::to(['/payment/account'])]
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Amount</label>
                                <?=
                                $form->field($model, 'amount')->widget(DepDrop::classname(), [
                                    'pluginOptions'=>[
                                        'depends'=>['payment-payment_account','payment-account_no'],
                                        'url'=>Url::to(['/payment/amount'])
                                    ],
                                    'options' => [
                                        'disabled'=>true,
                                    ],
                                ])->label(false);?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Payment Mode</label>
                                <?= $form->field($model, 'payment_mode')->dropDownList(['Cash'=>'Cash','Cheque'=>'Cheque'],
                                    [
                                        'prompt'=>'Choose Payment Method',
                                        'class'=>'form-control'
                                   ]
                                )->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Paid by</label>
                                <?= $form->field($model, 'paid_by')->textInput(['maxlength' => true,'placeholder'=>'Enter Name'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
