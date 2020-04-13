<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Event;
use frontend\models\EventSearch;
use yii\web\NotFoundHttpException;
use frontend\models\Attendant;
use yii\data\ActiveDataProvider;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends MyController
{
    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList()
    {
        /*if(Yii::$app->language=='ru')
        {
            $content_lang='1';
        }
        else{
            $content_lang='0';
        }*/
        $uQuery = Event::find();
        $pQuery = Event::find();
        $proj = Yii::$app->request->get('project_id');
        if ($proj) {
            $uQuery  = $uQuery->innerJoinWith('items')->where(['project_id' => $proj, 'item' => 'event']);
            $pQuery  = $pQuery->innerJoinWith('items')->where(['project_id' => $proj, 'item' => 'event']);
        }
        $upcomingDataProvider = new ActiveDataProvider([
            'query' => $uQuery->andWhere("date_end>NOW()")->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $pastDataProvider = new ActiveDataProvider([
            'query' => $pQuery->where("date_end<NOW()")->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('list', [
            'upcomingDataProvider' => $upcomingDataProvider,
            'pastDataProvider' => $pastDataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $amodel = new Attendant();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'amodel' => $amodel
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Event model.
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
     * Deletes an existing Event model.
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
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
