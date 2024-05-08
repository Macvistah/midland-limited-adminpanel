<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = "View Employee";
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="employee-view">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">View Employee Details</h4>
                    <p class="card-category">Fill all the required fields</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    //'id',
                                    'fname',
                                    'sname',
                                    'gender',
                                    'national_id',
                                    'email:email',
                                    'phone_no',
                                    'marital_status',
                                    'role',
                                    'location',
                                    'address',
                                    'postal_code',
                                    'created_on:date',
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <p class="pull-right">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                        <?php Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
