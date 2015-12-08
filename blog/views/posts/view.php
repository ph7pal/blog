<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use app\models\PrePosts;
/* @var $this yii\web\View */
/* @var $model app\models\PrePosts */
$this->title = $model->title;
?>  
<div class="pre-posts-view"> 
    <?=
    Breadcrumbs::widget([
        'links' => [
            ['label' => '首页', 'url' => ['site/index']],
            ['label' => $colInfo['title'], 'url' => ['site/index','colid'=>$colInfo['id']]],
            PrePosts::cutstr($this->title,80),
        ],
        'homeLink' => false
    ])
    ?>
    <div class="content">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php echo $model->content; ?>
    </div>
</div>
