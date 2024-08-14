<?php

use hesabro\changelog\models\MGLogs;
use hesabro\changelog\Module;
use hesabro\helpers\widgets\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel hesabro\changelog\models\MGLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->model_class;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Mongo Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div>

        </div>
        <div>
            <?= Html::a(Module::t('app','All'),
                ['/mongo/log/index', 'MGLogSearch[model_id]' => $searchModel->model_id, 'MGLogSearch[model_class]' => $searchModel->model_class],
                [
                    'class' => 'btn btn-secondary',
                    'title' => Module::t('app', 'All'),
                    'data-size' => 'modal-xl'
                ]); ?>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-product-info">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => ['id' => 'grid-log-view'],
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'class' => 'kartik\grid\ExpandRowColumn',
                            'expandIcon' => '<span class="fal fa-chevron-down" style="font-size: 13px"></span>',
                            'collapseIcon' => '<span class="fal fa-chevron-up" style="font-size: 13px"></span>',
                            'value' => function ($model, $key, $index, $column) {
                                return GridView::ROW_COLLAPSED;
                            },
                            'detail' => function ($model, $key, $index, $column) {
                                $className = $model->model_class;
                                if(!in_array($className, MGLogs::itemAlias('IgnoreClass')))
                                {
                                    $owner = new $className();
                                }else{
                                    $owner = new \yii\base\Model();
                                }

                                return Yii::$app->controller->renderPartial('_logs', [
                                    'owner' => $owner,
                                    'logs' => $model->logs,
                                    'params' => $model->params,
                                ]);
                            },
                        ],
                        [
                            'attribute' => 'created',
                            'value' => function ($model) {
                                return Yii::$app->jdate->date("Y/m/d  H:i:s", $model->created);
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'update_id',
                            'value' => function ($model) {
                                return $model->update->fullName ?? null;
                            },
                            'format' => 'raw'
                        ],
                        'controller',
                        'action',
						'model_class',
						'model_id',
                        [
                            'attribute' => 'checked',
                            'value' => function (MGLogs $model) {
                                return $model->checked ? '<span class="ti-check"></span>' : ($model->checked = MGLogs::UNCHECKED ? '<span class="ti-close"></span>' : null);
                            },
                            'format' => 'html'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
