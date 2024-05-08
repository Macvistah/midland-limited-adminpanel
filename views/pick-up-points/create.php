<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PickUpPoints */

$this->title = 'Create Pick Up Points';
$this->params['breadcrumbs'][] = ['label' => 'Pick Up Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pick-up-points-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
