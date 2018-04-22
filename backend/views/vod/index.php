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
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vod', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
                'class' => 'common\widgets\goPager',
                'go' => true
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'vod_name',
            //'vod_id',
            [
                    'attribute' => 'vod_cid',
                    'filter' => ArrayHelper::map(VodList::getAllList(),  'list_id', 'list_name'),
                    'value' => 'list.list_name'
            ],
            [
                    'attribute' => 'vod_ispay',
                    'filter' => Vod::$chargeStatus,
                    'value' => function($model) {
                        return Vod::$chargeStatus[$model->vod_ispay];
                    }
            ],
            [
                    'attribute' => 'vod_price',
                    'options' => ['style' => 'width:60px;']
            ],
            [
                'attribute' => 'vod_hits',
                'options' => ['style' => 'width:100px;']
            ],
            [
                'attribute' => 'vod_gold',
                'options' => ['style' => 'width:100px;']
            ],

            [
                    'attribute' => 'vod_stars',
                    'filter' => Vod::$starStatus,
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->star;
                    }
            ],
            'vod_addtime:datetime',
            [
                    'class' => 'common\grid\MyActionColumn',
                    'template' => '{banner-create} {view} {update} {delete}',
                    'buttons' => [
                            'banner-create' => function($url, $model, $key) {
                                return \yii\bootstrap\Html::a('发布banner', ['banner/create','vod_id' => $model->vod_id], [
                                    'class' => 'btn btn-default btn-xs'
                                ]);
                            }
                    ]
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
    <?php Pjax::end(); ?>
</div>