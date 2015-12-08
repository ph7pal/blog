<?php
use yii\helpers\Html;
use app\models\PrePosts;
?>
<?php echo Html::a(PrePosts::cutstr($model->title,80), ['posts/view','id'=>$model->id],['class'=>'list-group-item','title'=>$model->title]) ?>