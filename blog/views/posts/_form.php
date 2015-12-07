<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PreColumn;

/* @var $this yii\web\View */
/* @var $model app\models\PrePosts */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
$this->registerJsFile('@web/ueditor/ueditor.config.js',['position'=>$this::POS_END]); 
$this->registerJsFile('@web/ueditor/ueditor.all.min.js',['position'=>$this::POS_END]); 
$this->registerJsFile('@web/ueditor/lang/zh-cn/zh-cn.js',['position'=>$this::POS_END]); 
$this->registerJs(
   '$("document").ready(function(){ 
        var ue = UE.getEditor("'.Html::getInputId($model, 'content').'",{
            toolbar: ["bold","italic","underline","link","unlink","image","source","paragraph","insertcode"],
            initialStyle:".edui-editor-body .edui-body-container p{font-size:13px;line-height:1.3em;}.edui-container .edui-toolbar{z-index:0 !important}",
            textarea:"'.Html::getInputName($model, 'content').'"
            });
    });'
);
?>
<div class="pre-posts-form">
    <?php $form = ActiveForm::begin();?>
    <?= $form->field($model, 'colid')->dropDownList(PreColumn::allCols()) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <script type="text/plain" id="<?=Html::getInputId($model, 'content')?>" style="width:1000px;height:240px;"><?=$model->content?></script>
    <?= $form->field($model, 'sourceurl')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sourceinfo')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>