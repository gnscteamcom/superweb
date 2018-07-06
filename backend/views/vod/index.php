<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Vod;
use yii\helpers\ArrayHelper;
use \common\models\VodList;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\VodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vod-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('发布片源', \yii\helpers\Url::to(['create','vod_cid' => Yii::$app->request->get('VodSearch')['vod_cid']]), ['class' => 'btn btn-success']) ?>

        <?php if(strpos(Yii::$app->request->referrer, 'vod-list') !== false): ?>
            <?= Html::a('返回', null, [
                    'class' => 'btn btn-default',
                    'onclick' => 'history.go(-1)'
            ]) ?>
        <?php else: ?>
            <?= Html::a('返回', ['vod-list/index'], [
                'class' => 'btn btn-default',
                'onclick' => 'history.go(-1)'
            ]) ?>
        <?php endif; ?>

    </p>


    <?php // $this->render('_search', ['model' => $searchModel]); ?>

    <?php $search = Yii::$app->request->get('VodSearch'); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        "options" => ["class" => "grid-view","style"=>"overflow:auto", "id" => "grid"],
        'pager' => ['class' => 'common\widgets\goPager', 'go' => true],
        'columns' => [

            [
                'class' => 'yii\grid\SerialColumn'
            ],

            [
                "class" => "yii\grid\CheckboxColumn",
                "name" => "id",
            ],

            [
                  'attribute' => 'vod_name',
                  'filterInputOptions' => [
                    'placeholder' => '输入影片名称',
                    'class' => 'form-control'
                  ]

            ],
            //'vod_id',

            [
                    'attribute' => 'vod_type',
                    'filter' => \backend\models\IptvType::getVodType($search['vod_cid']),
                    'filterInputOptions' => [
                            'prompt' => '请选择',
                            'class' => 'form-control'
                    ]
            ],

            /* [
                    'attribute' => 'vod_cid',
                    'filter' => ArrayHelper::map(VodList::getAllList(),  'list_id', 'list_name'),
                    'value' => 'list.list_name'
            ],*/


          /*  [
                    'attribute' => 'vod_ispay',
                    'filter' => Vod::$chargeStatus,
                    'value' => function($model) {
                        return Vod::$chargeStatus[$model->vod_ispay];
                    }
            ],
            [
                    'attribute' => 'vod_price',
                    'options' => ['style' => 'width:60px;']
            ],*/
             [
                  'attribute' => 'vod_gold',
                  'options' => ['style' => 'width:100px;']
              ],
            /*[
                'attribute' => 'vod_hits',
                'options' => ['style' => 'width:100px;']
            ],*/
            /*[
                'attribute' => 'vod_gold',
                'options' => ['style' => 'width:100px;']
            ],*/

            /*[
                    'attribute' => 'vod_stars',
                    'filter' => Vod::$starStatus,
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->star;
                    }
            ],*/
            'vod_addtime:date',
            [
                    'class' => 'common\grid\MyActionColumn',
                    'template' => '{push-home} {banner-create}&nbsp;&nbsp;&nbsp;&nbsp;{link-create} {view} {update} {delete}',
                    'buttons' => [
                            'banner-create' => function($url, $model, $key) {
                                return Html::a('发布banner', ['banner/create','vod_id' => $model->vod_id], [
                                    'class' => 'btn btn-default btn-xs'
                                ]);
                            },
                            'link-create' => function($url, $model) {
                                return Html::a('链接列表', ['link/index', 'vod_id' => $model->vod_id], [
                                    'class' => 'btn btn-success btn-xs'
                                ]);
                            },
                            'push-home' => function($url, $model, $key) {
                            $text = $model->vod_home ? '取消推荐' : '首页推荐';
                            return Html::a($text, ['vod/push-home','id' => $model->vod_id,'action' => $model->vod_home ? '0' : '1' ], [
                                'class' => 'btn btn-xs ' . ($model->vod_home? 'btn-success' : 'btn-default')
                            ]);
                        },
                    ],
                    'options' => ['style' => 'width:350px;'],
                    'header' => '操作'
            ],
            //'vod_title',
            //'vod_ename',
            //'vod_keywords',
            //'vod_type',
            //'vod_actor',
            //'vod_director',
            //'vod_content:ntext',
            //'vod_pic',
            //'vod_pic_bg',
            //'vod_pic_slide',
            //'vod_area',
            //'vod_language',
            //'vod_year',
            //'vod_continu',
            //'vod_total',
            //'vod_isend',
            //'vod_addtime:datetime',
            //'vod_filmtime:datetime',
            //'vod_hits',
            //'vod_hits_day',
            //'vod_hits_week',
            //'vod_hits_month',
            //'vod_stars',
            //'vod_status',
            //'vod_up',
            //'vod_down',

            //'vod_price',
            //'vod_trysee',
            //'vod_play',
            //'vod_server',
            //'vod_url:ntext',
            //'vod_inputer',
            //'vod_reurl',
            //'vod_jumpurl',
            //'vod_letter',
            //'vod_skin',
            //'vod_gold',
            //'vod_golder',
            //'vod_length',
            //'vod_weekday',
            //'vod_series',
            //'vod_copyright',
            //'vod_state',
            //'vod_version',
            //'vod_douban_id',
            //'vod_douban_score',
            //'vod_scenario:ntext',


        ],
    ]); ?>


</div>



<?php

echo Html::button("批量删除",[
    'class' => 'gridview btn btn-danger',
]);

$batchDelete = \yii\helpers\Url::to(['vod/batch-delete']);

$requestJs=<<<JS
    $(document).on("click", ".gridview", function () {
                var keys = $("#grid").yiiGridView("getSelectedRows");
                var url = '{$batchDelete}' + '&id=' + keys.join(',');
                window.location.href = url;
            });
JS;

$this->registerJs($requestJs);
?>
