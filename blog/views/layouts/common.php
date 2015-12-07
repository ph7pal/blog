<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

$this->title = $this->title.' - '.Yii::$app->params['sitename'];

$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::$app->params['sitedesc']
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Yii::$app->params['keywords']
]);
$this->registerMetaTag([
    'name' => 'author',
    'content' => Yii::$app->params['author']
]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
