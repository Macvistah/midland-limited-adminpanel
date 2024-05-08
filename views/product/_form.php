<?php


use kartik\file\FileInput;
use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord){
    $title = 'Create Product';
}else{
    $title = 'Edit Product';
}
$categories = \yii\helpers\ArrayHelper::map(\app\models\ProductCategory::find()->all(),'id','name');
?>

<div class="product-form">
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown ">
            <a href="#" data-toggle="dropdown" aria-expanded="false">
                <h6 class="text-light " data-toggle="tooltip" title="Click to add new category">Add Category</h6>
            </a>
            <ul class="dropdown-menu" x-placement="top-start" style="position: absolute; top: -110px; left: -231px; will-change: top, left;">
                <li class="header-title"> Create Category</li>
                <?php
                $modelCategory = new \app\models\ProductCategory();
                ?>
                <?= $this->render('category_form', [
                    'model' => $modelCategory,
                ]);?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title"><?= $title ?></h4>
                    <p class="card-category">Fill all the required fields</p>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Product Name</label>
                                <?= $form->field($model, 'prod_name')->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Product Category</label>
                                <?= $form->field($model, 'category_id')->dropdownList($categories,['prompt'=>'Select category'])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Quantity</label>
                                <?= $form->field($model, 'qty')->textInput(['type'=>'number'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Unit Price (Ksh)</label>
                                <?= $form->field($model, 'price')->textInput(['type'=>'number'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Discount (%)</label>
                                <?= $form->field($model, 'discount')->textInput()->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Description</label>
                                <?= $form->field($model, 'description')->textarea(['rows' => 3])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-center text-dark">Product Photo</p>
                        </div>
                    </div>
                    <br>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="file_input_div">
                                <div class="file_input">
                                    <label class= 'bmd-label-floating mr-4 '>
                                        <span class="btn btn-primary btn-sm mt-0">Choose Image</span>
                                        <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                                            'options' => [
                                                    'class'=>'none',
                                                    'id'=>'file_input_file',
                                                    'multiple' => false, 'accept' => 'image/*',
                                                'onchange'=> 'readURL(this)',
                                            ],
                                            'pluginOptions' => ['previewFileType' => 'image']
                                        ])->label(false);?>
                                    </label>
                                </div>
                                <div id="file_input_text_div" class="mdl-textfield mdl-js-textfield textfield-demo ">
                                    <input class="file_input_text mdl-textfield__input" type="text" disabled readonly id="file_input_text" />
                                    <label class="mdl-textfield__label" for="file_input_text"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <p class="text-success text-center">Preview Photo</p>
                            <img id="preview" align="center"class="product_img">
                        </div>
                        <?php
                            if(!$model->isNewRecord){
                                if ($model->image!=null){
                        ?>
                            <div class="col-md-4 ">
                                <div class="align-content-center ">
                                    <p class="text-danger text-center">Current Photo</p>
                                    <img src="../../uploads/product_images/<?= $model->image?>" class="product_img" >
                                </div>

                            </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                    <br>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var fileInputTextDiv = document.getElementById('file_input_text_div');
    var fileInput = document.getElementById('file_input_file');
    var fileInputText = document.getElementById('file_input_text');

    fileInput.addEventListener('change', changeInputText);
    fileInput.addEventListener('change', changeState);

    function changeInputText() {
        var str = fileInput.value;
        var i;
        if (str.lastIndexOf('\\')) {
            i = str.lastIndexOf('\\') + 1;
        } else if (str.lastIndexOf('/')) {
            i = str.lastIndexOf('/') + 1;
        }
        fileInputText.value = str.slice(i, str.length);
    }

    function changeState() {
        if (fileInputText.value.length != 0) {
            if (!fileInputTextDiv.classList.contains("is-focused")) {
                fileInputTextDiv.classList.add('is-focused');
            }
        } else {
            if (fileInputTextDiv.classList.contains("is-focused")) {
                fileInputTextDiv.classList.remove('is-focused');
            }
        }
    }
</script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>