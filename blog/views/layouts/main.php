<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

use app\models\PreColumn;

$cols=  PreColumn::allFirstCols();
AppAsset::register($this);
$this->beginContent('@frontend/views/layouts/common.php');
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">导航条</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><?php echo Html::a('首页', ['/site/index']);?></li>
                <?php foreach($cols as $colid=>$title){?>
                <li><?php echo Html::a($title, ['/site/index','colid'=>$colid],['title'=>$title]);?></li>
                <?php }?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (Yii::$app->user->isGuest) {?>
                <li><?php echo Html::a('登录', ['/site/login']) ?></li>
                <?php }else{?>
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo Yii::$app->user->identity->truename;?><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><?php echo Html::a('新增文章', ['/posts/create'],['data-ajax'=>'false']) ?></li>
                        <li role="presentation" class="divider"></li>
                        <li><?php echo Html::a('退出', ['/site/logout'],['data-method' => 'post']) ?></li>                            
                    </ul>
                </li>
                <?php }?>
            </ul>
        </div><!--/.nav-collapse -->
    </div> 
</div>
<div class="wrap">
    <div class="container" id="pjax-container"><?= $content ?></div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy;阿年飞少 <?= date('Y') ?></p>
        <p class="pull-right">渝ICP备15005112号</p>
    </div>
</footer>
<?php $this->endContent(); ?>