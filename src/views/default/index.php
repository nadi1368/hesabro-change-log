<?php

use hesabro\changelog\models\MGLogs;
use hesabro\changelog\Module;
use hesabro\helpers\widgets\grid\GridView;

/* @var yii\web\View $this */
/* @var hesabro\changelog\models\MGLogSearch $searchModel */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Module::t('module', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="panel-group m-bot20" id="accordion">
        <div class="card-header d-flex justify-content-between">
            <h4 class="panel-title">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false">
                    <i class="far fa-search"></i> جستجو
                </a>
            </h4>
            <div>
            </div>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'expandIcon' => '<span class="ti-angle-down" style="font-size: 13px"></span>',
                    'collapseIcon' => '<span class="ti-angle-up" style="font-size: 13px"></span>',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model, $key, $index, $column) {
                        $className = $model->model_class;

                        if (!in_array($className, MGLogs::itemAlias('IgnoreClass'))) {
                            $owner = new $className();
                        } else {
                            $owner = new \yii\base\Model();
                        }
                        return Yii::$app->controller->renderPartial('_logs', [
                            'owner' => $owner,
                            'logs' => $model->logs,
                            'params' => $model->params,
                        ]);
                    },
                ],
                'model_class',
                'model_id',
                [
                    'attribute' => 'created',
                    'value' => function ($model) {
                        return Yii::$app->jdf->jdate("Y/m/d  H:i:s", $model->created);
                    },
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'update_id',
                    'value' => function ($model) {
                        return $model->update?->fullName;
                    },
                    'format' => 'raw'
                ],
                'controller',
                'action',
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