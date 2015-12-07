<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PrePosts */

$this->title = '新增文章';
?>
<div class="pre-posts-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>