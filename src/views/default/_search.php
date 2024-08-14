<?php

use hesabro\changelog\Module;
use hesabro\helpers\widgets\DateRangePicker\DateRangePicker;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var hesabro\changelog\models\MGLogSearch $model */

?>
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>
<div class="card-body">
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'model_class')->textInput() ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'model_id')->textInput() ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'from_date')->widget(dateRangePicker::class, [
                'options'     => [
                    'locale'            => [
                        'format' => 'jYYYY/jMM/jDD HH:mm',
                    ],
                    'drops'             => 'down',
                    'opens'             => 'right',
                    'jalaali'           => true,
                    'showDropdowns'     => true,
                    'language'          => 'fa',
                    'singleDatePicker'  => true,
                    'useTimestamp'      => true,
                    'timePicker'        => true,
                    'timePickerSeconds' => false,
                    'timePicker24Hour'  => true
                ],
                'htmlOptions' => [
                    'id'           => 'mglogsearch-from-date',
                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                ]
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'to_date')->widget(dateRangePicker::class, [
                'options'     => [
                    'locale'            => [
                        'format' => 'jYYYY/jMM/jDD HH:mm',
                    ],
                    'drops'             => 'down',
                    'opens'             => 'right',
                    'jalaali'           => true,
                    'showDropdowns'     => true,
                    'language'          => 'fa',
                    'singleDatePicker'  => true,
                    'useTimestamp'      => true,
                    'timePicker'        => true,
                    'timePickerSeconds' => false,
                    'timePicker24Hour'  => true
                ],
                'htmlOptions' => [
                    'id'           => 'mglogsearch-to-date',
                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                ]
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'update_id')->widget(Select2::class, [
                'initValueText' => $model->update ? $model->update?->fullName : 0,
                'options' => ['placeholder' => Module::t('module', 'Search')],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'خطا در جستجوی اطلاعات'; }"),
                        'inputTooShort' => new JsExpression("function () { return 'لطفا تایپ نمایید'; }"),
                        'loadingMore' => new JsExpression("function () { return 'بارگیری بیشتر'; }"),
                        'noResults' => new JsExpression("function () { return 'نتیجه ای یافت نشد.'; }"),
                        'searching' => new JsExpression("function () { return 'در حال جستجو...'; }"),
                        'maximumSelected' => new JsExpression("function () { return 'حداکثر انتخاب شده'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/user/get-user-list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(user) { return user.text; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'controller')->textInput() ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'action')->textInput() ?>
        </div>
        <div class="col align-self-center text-right">
            <?= Html::submitButton(Module::t('module', 'Search'), ['class' => 'btn btn-primary btn  ']) ?>
            <?= Html::resetButton(Module::t('module', 'Reset'), ['class' => 'btn btn-secondary btn  ']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>