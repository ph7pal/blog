<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PrePosts */

$this->title = '更新' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pre Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pre-posts-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>