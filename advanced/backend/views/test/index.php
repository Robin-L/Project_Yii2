<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Test', ['create'], [
            'class' => 'btn btn-success',
            'id' => 'create',
            'data-toggle' => 'modal',
            'data-target' => '#operate-modal',
        ]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'header' => '操作',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a("信息", $url, [
                            'title' => '栏目信息',
                            'class' => 'btn btn-default btn-update',
                            'data-toggle' => 'modal',
                            'data-target' => '#operate-modal',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a("删除", $url, [
                            'title' => '删除',
                            'class' => 'btn btn-default btn-update',
                            'data' => [
                                'confirm' => '确定要删除么？',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
</div>

<?php
Modal::begin([
    'id' => 'operate-modal',
    'header' => '<h4 class="modal-title"></h4>',
]);
Modal::end();

$requestCreateUrl = Url::toRoute('create');
$requestUpdateUrl = Url::toRoute('update');
$js = <<<JS
    $('#create').on('click', function() {
        $('.modal-title').html('创建栏目');
        $.get('{$requestCreateUrl}', function(data) {
            $('.modal-body').html(data);
        });
    });
    $('.btn-update').on('click', function() {
        $('.modal-title').html('信息');
        $.get('{$requestUpdateUrl}', {id:$(this).closest('tr').data('key')}, function(data) {
            $('.modal-body').html(data);
        });
    });
JS;
$this->registerJs($js);
?>
