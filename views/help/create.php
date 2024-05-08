<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Help */

$this->title = 'Create FAQ';
$this->params['breadcrumbs'][] = ['label' => 'Helps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
