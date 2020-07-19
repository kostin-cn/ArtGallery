<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Faq */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modules-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
