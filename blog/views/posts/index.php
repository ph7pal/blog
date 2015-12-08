<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;
$this->title=$colInfo ? $colInfo['title'] : '文章列表';
?>
<div class="pre-posts-view">
    <?=Breadcrumbs::widget([
        'links' => $links,
        'homeLink'=>false
        ])?>
    <?php if(!empty($subs)){?>
    <div class="col-subs">全部子类：
    <?php foreach($subs as $_colid=>$_coltitle){?>
    <?=Html::a($_coltitle, ['/site/index','colid'=>$_colid]) ?>
    <?php }?>
    </div>
    <?php }?>
    <div class="list-group content posts-list">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '/posts/_item',
        'summary'=>'',
        'separator'=>'',
        'layout'=> "{items}\n{pager}",
        'viewParams' => [
            'fullView' => true,
        ],
    ]); ?>
    </div>
</div>