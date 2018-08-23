<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use backend\models\Cache;
use backend\models\LinkToScheme;
use backend\models\Mac;
use backend\models\MacDetail;
use backend\models\MiddleParade;
use backend\models\Parade;
use backend\models\Scheme;
use common\models\MainClass;
use common\models\OttLink;
use common\models\Vod;
use common\models\Vodlink;
use common\models\VodList;
use console\components\MySnnopy;
use console\models\movie\IMDB;
use console\models\movie\OMDB;
use console\models\profile;
use Symfony\Component\DomCrawler\Crawler;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Query;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    public $message;
    public $day;


    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        $query = new Query();
        $query->from('mac_detail');
        foreach($query->batch() as $users){
            foreach($users as $user){
               if (!empty($user['client_id']) && !empty($user['MAC'])) {
                   Mac::updateAllCounters(['client_id' => $user['client_id']], [
                      'MAC' => $user['MAC']
                   ]);
               }
            }
        }


        return ExitCode::OK;
    }

    public function actionCache()
    {
        $data = MainClass::find()
                ->with('subChannel')
                ->asArray()
                ->all();

        foreach ($data as $class) {
            foreach ($class['subChannel'] as $channel) {

                 if (empty($channel['alias_name'])) continue;


                 $parade = Parade::find()->where(['channel_name' => $channel['alias_name']])
                                             ->andWhere(['<=', 'parade_date', date('Y-m-d', strtotime('+4 day'))])
                                             ->asArray()
                                             ->all();



                 if (!empty($parade)) {
                     $exist = MiddleParade::find()->where(['channel' => trim($channel['name']), 'genre' => trim($class['name'])])->exists();
                     if ($exist == false) {
                         $middleParade = new MiddleParade();
                         $middleParade->channel = $channel['name'];
                         $middleParade->genre = $class['name'];
                         $middleParade->parade_content = json_encode($parade);
                         $middleParade->save(false);
                     }
                 }
            }
        }

        echo 'ok';

    }

    public function actionMaintain()
    {
        $links = OttLink::find()->all();
        foreach ($links as $link) {
            if (empty($link->scheme_id)) {
                $link->scheme_id = 'all';
                $link->save(false);
            }
        }
    }

    /**
     * 测试生成缓存
     */
    public function actionList()
    {
        $mainClass = MainClass::find()
            ->where(['use_flag' => 1])
            ->orderBy(['id' => 'asc', 'sort' => 'asc'])
            ->all();

        $cache = new Cache();

        foreach ($mainClass as $class) {
            $this->stdout("generate {$class->name}" . PHP_EOL);
            $cache->createOttCache($class->id, Cache::$XML);
            $cache->createOttCache($class->id, Cache::$JSON);
        }

    }


    public function actionTest()
    {
        $snnopy = MySnnopy::init();
        $snnopy->fetch('https://movie.douban.com/subject/26942674/');

        $crawler = new Crawler();
        $crawler->addHtmlContent($snnopy->results, "UTF-8");

        $crawler
           // ->filter('div#subject')
            ->filterXpath('//div[@id="info"]')
            ->filterXpath('//span[contains(./text(), "语言:")]/following::text()[1]')
            ->each(function(Crawler $node) {
                echo $node->text();
            })
        ;

    }
}
