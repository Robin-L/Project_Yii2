<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <?php
    Modal::begin([
        'id' => 'operate-modal',
        'header' => '<h4 class="modal-title"></h4>',
    ]);
    Modal::end();
    ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建栏目', ['create'], [
            'class' => 'btn btn-success',
            'id'    => 'create',
            'data-toggle' => 'modal',
            'data-target' => '#operate-modal',
        ]);?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<?php
$requestCreateUrl = Url::toRoute('create');
$js = <<<JS
$('#create').on('click', function() {
    $('.modal-title').html('创建栏目');
    $.get('{$requestCreateUrl}', function(data) {
      $('.modal-body').html(data);
    });
});
JS;
$this->registerJs($js);
?>
