<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = 'Registration';


?>
<div>
    <h1><?= Html::encode($this->title)?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]);
    ?>
    <?= $form->field($model, 'login')->textInput();?>
    <?= $form->field($model, 'password')->passwordInput();?>
    <?= $form->field($model, 'email')->textInput();?>
    <?= $form->field($model, 'name')->textInput();?>
    <?= $form->field($model, 'lastname')->textInput();?>
    <?= $form->field($model, 'birthday')->widget(DatePicker::className(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd'
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'registration-button']) ?>
    </div>
    <?
    ActiveForm::end();
    ?>
</div>