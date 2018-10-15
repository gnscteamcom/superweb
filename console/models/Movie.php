<?php
/**
 * Created by PhpStorm.
 * User: lychee
 * Date: 2018/10/15
 * Time: 13:43
 */

namespace console\models;

use backend\models\PlayGroup;
use common\models\Vod;
use common\models\Vodlink;
use common\models\VodList;
use Yii;

class Movie extends Vod
{
    public function collect($data, $playGroup = 'default')
    {
        $title = $data['title'];
        $url   = $data['url'];
        $image = $data['image'];
        $info  = $data['info'];
        $area  = $data['area'];
        $groupName = $playGroup;

        $title = trim($title);
        $data = Vod::findOne(['vod_name' => $title]);

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();  //开启事务

        try {
            if (empty($data)) {

                $genre = VodList::findOne(['list_dir' => 'Movie']);

                if (empty($genre)) {
                    echo "请新增Movie分类" , PHP_EOL;
                    return false;
                }

                $movie = new Vod();

                $movie->vod_name = $title;
                $movie->vod_pic = $image;
                $movie->vod_pic_bg = $image;
                $movie->vod_content = $info;
                $movie->vod_area = $area;
                $movie->vod_cid = $genre->list_id;
                $movie->save(false);

                // 新增一个播放分组
                $playGroup = new PlayGroup();
                $playGroup->vod_id = $movie->vod_id;
                $playGroup->group_name = $groupName;
                $playGroup->save(false);

                // 新增播放链接
                $link = new Vodlink();
                $link->url = $url;
                $link->episode = 1;

                $link->link('group', $playGroup);

                echo $title . "新增" . PHP_EOL;
            } else {
                echo $title . "存在" . PHP_EOL;
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            echo $e->getMessage() . PHP_EOL;
            sleep(5);
        }

        return false;
    }
}