<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Help */
/* @var $form yii\widgets\ActiveForm */
if (!$model->isNewRecord){
    $title = 'Edit FAQ';
}else{
    $title = 'Create FAQ';
}
$modelTitle = \app\models\HelpTitle::find()->all();
$titles = \yii\helpers\ArrayHelper::map($modelTitle,'id','title');
?>

<div class="help-form">
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown ">
            <a href="#" data-toggle="dropdown" aria-expanded="false">
                <h6 class="text-light " data-toggle="tooltip" title="Click to add new title">Add Title</h6>
            </a>
            <ul class="dropdown-menu" x-placement="top-start" style="position: absolute; top: -110px; left: -231px; will-change: top, left;">
                <li class="header-title"> Create Title</li>
                <?php
                $modelHelpTitle = new \app\models\HelpTitle();
                ?>
                <?= $this->render('title_form', [
                    'model' => $modelHelpTitle,
                ]);?>
            </ul>
        </div>
    </div>
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
                                <label class="bmd-label-floating">Title</label>
                                <?= $form->field($model, 'title_id')->dropdownList($titles,['maxlength' => true,'prompt'=>'Please Choose Title'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Visible To</label>
                                <?= $form->field($model, 'user_type')->dropdownList(['all'=>'All Users','sales manager'=>'Sales Manager','shipment manager'=>'Shipment Manager','finance'=>'Financial Manager','driver'=>'Drivers','customer'=>'Customers'],['maxlength' => true,'prompt'=>'Select an option'])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Question</label>
                                <?= $form->field($model, 'question')->textarea(['rows' => 3])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Answer</label>
                                <?= $form->field($model, 'answer')->textarea(['rows' => 3])->label(false) ?>
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
