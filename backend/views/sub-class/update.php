<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SubClass */

$this->title = 'Update Sub Class: ';
$this->params['breadcrumbs'][] =  $model->name;

$this->params['breadcrumbs'][] = '更新';
?>
<div class="sub-class-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>