<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Article;
use frontend\models\ArticleSearch;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;
use Exception;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends MyController
{

    public function actionList()
    {
        /*if(Yii::$app->language=='ru')
        {
            $content_lang='1';
        }
        else{
            $content_lang='0';
        }*/
        $query = Article::find();
        $ctg = Yii::$app->request->get('category');
        $proj = Yii::$app->request->get('project_id');
        if ($ctg) {
            $query = $query->where(['category_id' => $ctg]);
        }
        if ($proj) {
            $query = $query->innerJoinWith('items')->where(['project_id' => $proj, 'item' => 'article']);
        }
        $query->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->updateCounters(['views' => 1]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRun()
    {

        /*$dir=Yii::getAlias('@webroot')."/images/article/";

        $rows=Yii::$app->db->createCommand("SELECT id, image FROM article")->queryAll();
        foreach($rows as $row){
            $tosave=$dir.$row['id'];
            if(is_dir($tosave)){
                Image::thumbnail($tosave.'/'.$row['image'],600, 340)->save($tosave.'/m_'.$row['image']);
            }
        }*/
        $model = $this->findModel(231);
        $model->updateCounters(['views' => 1]);
        echo 'good';
    }
}
