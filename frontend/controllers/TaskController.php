<?php

namespace frontend\controllers;

use common\config\AuthItems;
use common\models\ProjectUser;
use common\models\query\TaskQuery;
use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => [AuthItems::ROLE_USER],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return in_array(ProjectUser::ROLE_MANAGER, Yii::$app->projectService->getAllRoles());
                        }
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $task = $this->findModel($this->getRequestId());
                            return Yii::$app->taskService->canManage($task->project, Yii::$app->user->identity);
                        }
                    ],
                    [
                        'actions' => ['take'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $task = $this->findModel($this->getRequestId());
                            return Yii::$app->taskService->canTake($task, Yii::$app->user->identity);
                        }
                    ],
                    [
                        'actions' => ['complete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $task = $this->findModel($this->getRequestId());
                            return Yii::$app->taskService->canComplete($task, Yii::$app->user->identity);
                        }
                    ],
                ],
            ],
        ];
    }
    /**
     * @return int
     */
    public function getRequestId()
    {
        $id = Yii::$app->request->get('id');
        $id = isset($id) ? $id : Yii::$app->request->post('id');
        return $id;
    }


    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        /** @var  $query TaskQuery*/
        $query = $dataProvider->query;
        $query->byUser(Yii::$app->user->id);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionTake($id)
    {
        $model = $this->findModel($id);
        $model->executor_id = Yii::$app->user->id;
        $model->started_at = time();

        if ($model->save()){
            Yii::$app->session->setFlash('success', 'Успешно');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionComplete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->taskService->completeTask($model)) {
            Yii::$app->session->setFlash('success', 'Задача завершена');
            return $this->redirect(['task/view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }


}
