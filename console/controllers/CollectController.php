<?php
/**
 * Created by PhpStorm.
 * User: lychee
 * Date: 2018/10/11
 * Time: 18:17
 */

namespace console\controllers;

use console\collectors\hlpus\HplusSearcher;
use console\collectors\youtube\Searcher;
use console\models\Cartoon;
use console\models\Karaoke;
use console\models\Movie;
use console\models\Tv;
use console\models\Variety;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * 采集控制器
 * Class CollectController
 * @package console\controllers
 */
class CollectController extends Controller
{
    public function actionHelp()
    {
        $this->stdout('php yii collect/karaoke [搜索内容] [地区] [语言] : 卡拉ok'.PHP_EOL, Console::FG_BLUE);
        $this->stdout('php yii collect/tv [搜索内容] [地区] [语言] : 电视剧'.PHP_EOL, Console::FG_BLUE);
        $this->stdout('php yii collect/movie [搜索内容] [地区] [语言] : 电影'.PHP_EOL, Console::FG_BLUE);
        $this->stdout('php yii collect/cartoon [搜索内容] [地区] [语言] : 卡通'.PHP_EOL, Console::FG_BLUE);
        $this->stdout('php yii collect/variety [搜索内容] [地区] [语言] : 综艺'.PHP_EOL, Console::FG_BLUE);

        $this->stdout("示例: php yii collect/movie 电影 Chinese Chinese");
    }

    // karaoke
    public function actionKaraoke($query = 'karaoke beat chuẩ', $area = 'Vietnam', $language = 'Vietnamese')
    {
        $karaoke = new Karaoke();
        $karaoke->setArea($area);
        $karaoke->setLanguage($language);

        $search  = new Searcher($karaoke);
        $options = [
            'q' => $query,//
            'maxResults' => 50,
            'type' =>  'video',
            'order' => 'relevance',
            'videoDuration' => 'short',
        ];
        $search->setQueryOption($options);
        $search->start();
    }

    // 采集Youtube 电视剧
    public function actionTv($query = 'Phim truyền hình', $area = 'Vietnam', $language = 'Vietnamese')
    {
        $tv = new Tv();
        $tv->setArea($area);
        $tv->setLanguage($language);

        $search = new Searcher($tv, 'playlist');
        $options = [
            'q' => $query,//
            'maxResults' => 50,
            'type' =>  'playlist',
        ];
        $search->setQueryOption($options);
        $search->start();
    }

    // 采集Youtube电影
    public function actionMovie($query = "Vietnam movie", $area = 'Vietnam', $language = 'Vietnamese')
    {
        $movie  = new Movie();
        $movie->setArea($area);
        $movie->setLanguage($language);
        $search = new Searcher($movie);
        $options = [
            'q' => $query,//
            'maxResults' => 50,
            'type' =>  'video',
            'order' => 'relevance',
            'videoDuration' => 'long',
        ];
        $search->setQueryOption($options);
        $search->start();
    }

    // 采集Youtube 动漫
    public function actionCartoon($query = "cartoons for kids", $area = 'Vietnam', $language = 'Vietnamese')
    {
        $movie  = new Cartoon();
        $movie->setArea($area);
        $movie->setLanguage($language);
        $search = new Searcher($movie);
        $options = [
            'q' => $query,//
            'maxResults' => 50,
            'type' =>  'video',
            'order' => 'relevance',
            'videoDuration' => 'long',
        ];
        $search->setQueryOption($options);
        $search->start();
    }

    // 采集Youtube 动漫
    public function actionVariety($query = "vietnam variety", $area = 'Vietnam', $language = 'Vietnamese')
    {
        $movie  = new Variety();
        $movie->setArea($area);
        $movie->setLanguage($language);
        $search = new Searcher($movie);
        $options = [
            'q' => $query,//
            'maxResults' => 50,
            'type' =>  'video',
            'order' => 'relevance',
            'videoDuration' => 'long',
        ];
        $search->setQueryOption($options);
        $search->start();
    }

    public function actionVnMovie()
    {
        $movie  = new Movie();
        $search = new HplusSearcher($movie);
        $search->collectMovie();
    }

    public function actionVnTv()
    {
        $tv  = new Tv();
        $search = new HplusSearcher($tv);
        $search->collectTv();
    }

    public function actionVnCarton()
    {
        $cartoon = new Cartoon();
        $search = new HplusSearcher($cartoon);
        $search->collectCarton();
    }

    public function actionVnVariety()
    {
        $variety = new Variety();
        $search = new HplusSearcher($variety);
        $search->collectVariety();
    }

}