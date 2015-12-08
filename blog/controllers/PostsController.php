<?php

namespace frontend\controllers;

use Yii;
use app\models\PrePosts;
use app\models\PreColumn;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PostsController implements the CRUD actions for PrePosts model.
 */
class PostsController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays a single PrePosts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $info = $this->findModel($id);
        $colInfo = PreColumn::findOne($info['colid']);
        $data = [
            'model' => $info,
            'colInfo' => $colInfo,
        ];
        return $this->render('view', $data);
    }

    /**
     * Creates a new PrePosts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = '') {
        $model = new PrePosts();
        $model->classify = 2;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('/posts/create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PrePosts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->uid != Yii::$app->user->id) {
            throw new ForbiddenHttpException('请操作自己的文章');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PrePosts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->uid != Yii::$app->user->id) {
            throw new ForbiddenHttpException('请操作自己的文章');
        }
        $model->delete();
        return $this->redirect(['site/index']);
    }

    /**
     * Finds the PrePosts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PrePosts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PrePosts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
