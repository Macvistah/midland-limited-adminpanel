<?php


use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Supplier */
/* @var $form yii\widgets\ActiveForm */

if (!$model->isNewRecord){
    $title = 'Edit Supplier Details';
}else{
    $title = 'Create New Supplier';
}
?>

<div class="supplier-form">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title"><?= $title ?></h4>
                    <p class="card-category">Fill all the required fields</p>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">First Name</label>

                                <?= $form->field($model, 'contact_fname')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter First Name'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Last Name</label>
                                <?= $form->field($model, 'contact_sname')->textInput(['maxlength' => true,'placeholder'=>'Enter Last Name'])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Gender</label>
                                <?= $form->field($model, 'contact_gender')->dropdownList(['Male'=>'Male','Female'=>'Female'],['maxlength' => true,'prompt'=>'Select gender'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Company Name</label>
                                <?= $form->field($model, 'company_name')->textInput(['placeholder'=>'Enter Company Name'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">KRA Pin</label>
                                <?= $form->field($model, 'kra_pin')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter KRA Pin'])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">National ID</label>
                                <?= $form->field($model, 'national_id')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter ID number','type'=>'number'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Phone Number</label>
                                <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Phone Number','type'=>'number'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Email</label>
                                <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true,'class'=>'form-control','type'=>'email','placeholder'=>'Enter Email Address'])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Location</label>
                                <?= $form->field($model, 'location')->textarea(['rows'=>6,'class'=>'form-control','placeholder'=>'Type Location'])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-info pull-right']) ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
