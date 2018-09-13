<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Video;
use frontend\models\VideoSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends MyController
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
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Video model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $model->updateCounters(['views'=>1]);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Video();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Video model.
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
     * Deletes an existing Video model.
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
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
