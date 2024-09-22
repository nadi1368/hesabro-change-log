<?php

use hesabro\changelog\models\MGLogs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $owner yii\db\ActiveRecord */
/* @var $logs string[] */
/* @var $params string[] */
?>

<?php if (is_array($logs)): ?>
    <table class="table table-bordered">
        <tr>
            <th>فیلد</th>
            <th>از</th>
            <th>به</th>
        </tr>
        <tbody>
        <?php foreach ($logs as $name => $value): ?>
            <?php if (is_array($value) && count($value)>2): ?>
                <tr>
                    <?= Html::tag('td', '') ?>
                    <?= Html::tag('td', $owner->getAttributeLabel($name)) ?>
                    <?= Html::tag('td', is_array($value) ? Yii::$app->helper->arrayToString($value) : Html::encode($value)) ?>
                </tr>
            <?php else: ?>
                <?php $changedValue = MGLogs::getChangedValue($name, $value, get_class($owner)); ?>
                <tr>
                    <?= Html::tag('td', $owner->getAttributeLabel($name)) ?>
                    <?= Html::tag('td', isset($changedValue['from']) ? (is_array($changedValue['from']) ? json_encode($changedValue['from']) : $changedValue['from']) : '') ?>
                    <?= Html::tag('td', isset($changedValue['to']) ? (is_array($changedValue['to']) ? json_encode($changedValue['to']) : $changedValue['to']) : '') ?>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php if (is_array($params)): ?>
    <table class="table table-bordered">
        <tr>
            <th></th>
            <th>متغیر</th>
            <th>مقدار</th>
        </tr>
        <tbody>
        <?php foreach ($params as $name => $value): ?>
            <tr>
                <?= Html::tag('td', '') ?>
                <?= Html::tag('td', Html::encode($name)) ?>
                <?= Html::tag('td', is_array($value) ? implode('#',$value) : Html::encode($value)) ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>