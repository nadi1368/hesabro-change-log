<?php

namespace hesabro\changelog\controllers;

use hesabro\changelog\models\MGLogs;
use hesabro\changelog\models\MGLogSearch;
use hesabro\changelog\Module;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['index'],
//                        'roles' => ['hesabro/changelog/default/index'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['view', 'view-ajax'],
//                        'roles' => ['hesabro/changelog/default/view'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['expand'],
//                        'roles' => ['hesabro/changelog/default/expand'],
//                    ],
//                ]
//            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MGLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $modelClass
     * @param $modelId
     * @return string
     */
    public function actionView($modelClass, $modelId, $hasSlaveId = true)
    {
        $searchModel = new MGLogSearch();
        $searchModel->model_class = $modelClass;
        $searchModel->model_id = $modelId;
        $searchModel->hasSlaveId = $hasSlaveId;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'showFilter' => false,
        ]);
    }

    /**
     * @param $modelClass
     * @param $modelId
     * @return string
     */
    public function actionViewAjax($modelClass, $modelId)
    {
        $searchModel = new MGLogSearch();
        $searchModel->model_class = $modelClass;
        $searchModel->model_id = $modelId;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'showFilter' => false,
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionExpand()
    {
        $id = Yii::$app->request->post('expandRowKey');
        $model = $this->findModel($id);
        $className = $model->model_class;
        $owner = new $className();
        return $this->renderAjax('_logs', [
            'owner' => $owner,
            'logs' => $model->logs,
            'params' => [],
        ]);
    }

    /**
     * Finds the MGLogs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MGLogs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MGLogs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Module::t('module', "The requested page does not exist."));
        }
    }
}
