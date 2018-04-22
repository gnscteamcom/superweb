<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * This is the model class for table "iptv_vod".
 *
 * @property int $vod_id 影片id
 * @property int $vod_cid 影片分类
 * @property string $vod_name 影片名称
 * @property string $vod_ename 影片别名
 * @property string $vod_title 影片副标
 * @property string $vod_keywords 影片TAG
 * @property string $vod_type 扩展分类
 * @property string $vod_actor 主演
 * @property string $vod_director 导演
 * @property string $vod_content 影片简介
 * @property string $vod_pic 海报剧照
 * @property string $vod_pic_bg 背景图片
 * @property string $vod_pic_slide 轮播图片
 * @property string $vod_area 发行地区
 * @property string $vod_language 影片对白
 * @property int $vod_year 发行年份
 * @property string $vod_continu 连载信息
 * @property int $vod_total 总共集数
 * @property int $vod_isend 是否完结
 * @property int $vod_addtime 更新日期
 * @property int $vod_filmtime 上映日期
 * @property int $vod_hits 总人气
 * @property int $vod_hits_day 日人气
 * @property int $vod_hits_week 周人气
 * @property int $vod_hits_month 月人气
 * @property int $vod_stars 推荐星级
 * @property int $vod_status 影片状态（0隐藏1显示）
 * @property int $vod_up 支持
 * @property int $vod_down 反对
 * @property int $vod_ispay 点播权限（0免费1VIP）
 * @property int $vod_price 单片付费
 * @property int $vod_trysee 影片试看
 * @property string $vod_play 播放器选择
 * @property string $vod_server 服务器地址
 * @property string $vod_url 播放地址
 * @property string $vod_inputer 录入编辑
 * @property string $vod_reurl 来源标识
 * @property string $vod_jumpurl 跳转URL
 * @property string $vod_letter 首字母
 * @property string $vod_skin 独立模板
 * @property string $vod_gold 评分值
 * @property int $vod_golder 评分人数
 * @property int $vod_length 影片时长
 * @property string $vod_weekday 节目周期
 * @property string $vod_series 影片系列(如“变形金刚”1、2、3部ID分别为77，88，99则每部影片此处填写为77,88,99；或将每部影片都填“变形金刚”（推荐）)
 * @property int $vod_copyright 版权跳转：
 * @property string $vod_state 资源类别(正片|预告片|花絮)
 * @property string $vod_version 版本(高清版|剧场版|抢先版|OVA|TV|影院版)
 * @property int $vod_douban_id 豆瓣ID
 * @property string $vod_douban_score 豆瓣评分
 * @property string $vod_scenario 影片剧情
 */
class Vod extends \yii\db\ActiveRecord implements Linkable
{

    public $showStatus = [
        '1' => '显示',
        '0' => '隐藏'
    ];

    public static $chargeStatus = [
        '0' => '免费点播',
        '1' => 'VIP点播'
    ];

    public static $starStatus = [
        '1' => '一星',
        '2' => '二星',
        '3' => '三星',
        '4' => '四星',
        '5' => '五星',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'iptv_vod';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vod_cid', 'vod_name', 'vod_trysee'], 'required'],
            [['vod_cid', 'vod_year', 'vod_total', 'vod_addtime', 'vod_filmtime', 'vod_hits', 'vod_hits_day', 'vod_hits_week', 'vod_hits_month', 'vod_up', 'vod_down', 'vod_price', 'vod_trysee', 'vod_golder', 'vod_length', 'vod_copyright', 'vod_douban_id'], 'integer'],
            [['vod_content', 'vod_url', 'vod_scenario'], 'string'],
            [['vod_gold', 'vod_douban_score'], 'number'],
            [['vod_name'], 'string', 'max' => 100],
            [['vod_ename', 'vod_title', 'vod_keywords', 'vod_type', 'vod_actor', 'vod_director', 'vod_pic', 'vod_pic_bg', 'vod_pic_slide', 'vod_play', 'vod_server', 'vod_reurl'], 'string', 'max' => 255],
            [['vod_area', 'vod_language'], 'string', 'max' => 10],
            [['vod_continu'], 'string', 'max' => 20],
            [['vod_inputer', 'vod_skin', 'vod_state', 'vod_version'], 'string', 'max' => 30],
            [['vod_jumpurl'], 'string', 'max' => 150],
            [['vod_letter'], 'string', 'max' => 2],
            [['vod_weekday'], 'string', 'max' => 60],
            [['vod_series'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vod_id' => '影片id',
            'vod_cid' => '影片分类',
            'vod_name' => '影片名称',
            'vod_ename' => '影片别名',
            'vod_title' => '影片副标',
            'vod_keywords' => '影片TAG',
            'vod_type' => '扩展分类',//喜剧 爱情 恐怖 动作 科幻 剧情 战争 警匪 犯罪 动画 奇幻 武侠 冒险 枪战 恐怖 悬疑 惊悚 经典 青春文艺 微电影 古装 历史运动 农村 儿童 网络电影
            'vod_actor' => '主演',
            'vod_director' => '导演',
            'vod_content' => '影片简介',
            'vod_pic' => '海报剧照',
            'vod_pic_bg' => '背景图片',
            'vod_pic_slide' => '轮播图片',
            'vod_area' => '发行地区', //内地 美国 香港 台湾 韩国 日本 法国 英国 德国 泰国 印度 欧洲 东南亚 其他
            'vod_language' => '影片对白',// 国语 英语 粤语 闽南语 韩语 日语 其它
            'vod_year' => '发行年份',
            'vod_continu' => '连载信息',
            'vod_total' => '总共集数',
            'vod_isend' => '是否完结',
            'vod_addtime' => '更新日期',
            'vod_filmtime' => '上映日期',
            'vod_hits' => '总人气',
            'vod_hits_day' => '日人气',
            'vod_hits_week' => '周人气',
            'vod_hits_month' => '月人气',
            'vod_stars' => '推荐星级',
            'vod_status' => '影片状态',//（0隐藏1显示）
            'vod_up' => '支持',
            'vod_down' => '反对',
            'vod_ispay' => '点播权限',
            'vod_price' => '影币',
            'vod_trysee' => '影片试看',
            'vod_play' => '播放器选择',
            'vod_server' => '服务器地址',
            'vod_url' => '播放地址',
            'vod_inputer' => '录入编辑',
            'vod_reurl' => '来源标识',
            'vod_jumpurl' => '跳转URL',
            'vod_letter' => '首字母',
            'vod_skin' => '独立模板',
            'vod_gold' => '评分值',
            'vod_golder' => '评分人数',
            'vod_length' => '影片时长',
            'vod_weekday' => '节目周期',
            'vod_series' => '影片系列',//(如“变形金刚”1、2、3部ID分别为77，88，99则每部影片此处填写为77,88,99；或将每部影片都填“变形金刚”（推荐）)
            'vod_copyright' => '版权跳转：',
            'vod_state' => '资源类别',//(正片|预告片|花絮)
            'vod_version' => '版本',//(高清版|剧场版|抢先版|OVA|TV|影院版)
            'vod_douban_id' => '豆瓣ID',
            'vod_douban_score' => '豆瓣评分',
            'vod_scenario' => '影片剧情',
        ];
    }

    public function fields()
    {
        return [
            'vod_id',
            'vod_cid' ,
            'vod_name',
            'vod_ename',
            'vod_type',//喜剧 爱情 恐怖 动作 科幻 剧情 战争 警匪 犯罪 动画 奇幻 武侠 冒险 枪战 恐怖 悬疑 惊悚 经典 青春文艺 微电影 古装 历史运动 农村 儿童 网络电影
            'vod_actor',
            'vod_director',
            'vod_content',
            'vod_pic',
            'vod_year' ,
            'vod_addtime',
            'vod_filmtime',
            'vod_ispay',
            'vod_price',
            'vod_trysee',
            'vod_url' => function(){
                return 'http://img.ksbbs.com/asset/Mon_1703/05cacb4e02f9d9e.mp4';
            },
            'vod_gold',
            'vod_length',
        ];
    }

    public function getLinks()
    {
       return [
           Link::REL_SELF => Url::to(['vod/view', 'id' => $this->vod_id], true)
       ];
    }

    public function getStar()
    {
        $str = '<font style="color:darkorange">';
        $starNum = floor($this->vod_stars);
        for ($i = 0 ; $i < $starNum; $i++) {
            $str .= '<i class="fa fa-star"><i>';
        }
        if ($starNum < 5) {
            for ($i = 0; $i <= 5 - $starNum; $i++) {
                $str .= '<i class="fa fa-star-o"><i>';
            }
        }
        $str .= '</font>';
        return $str;
    }

    public function getList()
    {
        return $this->hasOne(VodList::className(), ['list_id' => 'vod_cid']);
    }

    public static function getTags()
    {
        return ['喜剧','爱情','恐怖','动作','科幻','剧情','战争','警匪','犯罪','动画','奇幻','武侠','冒险','枪战','恐怖','悬疑','惊悚','经典','青春','文艺','古装','历史','体育','儿童','微电影'];
    }

    public static function getTagsSelect()
    {
        $tags = self::getTags();
        $str = '';
        foreach ($tags as $tag) {
            $str .= '<a href="javascript:;" class="select" data-id="vod-vod_type">'. $tag .'</a>&nbsp;';
        }
        return $str;
    }

    public static function getYears()
    {
        $years = [];
        for ($year = date('Y'); $year >= 2000; $year--) {
            $years[] = $year;
        }

        return $years;
    }


    public static function getAreas()
    {
        return ['大陆','美国','香港','台湾','韩国','日本','法国','英国','德国','泰国','印度','欧洲','东南亚','其他'];
    }

    public static function getLanguages()
    {
        return ['国语','英语','粤语','闽南语','韩语','日语','印度语','其它'];
    }

    public static function getVersions()
    {
        return ['高清版','剧场版','抢先版','OVA','TV','影院版'];
    }

    public function getResourceTypes()
    {
        return ['正片','预告片','花絮'];
    }

    public static function getSelectList($field)
    {
        switch ($field)
        {
            case 'vod_type':
                $tags = self::getTags();
                break;
            case 'vod_area':
                $tags = self::getAreas();
                break;
            case 'vod_year':
                $tags = self::getYears();
                break;
            case 'vod_language':
                $tags = self::getLanguages();
                break;
            case 'vod_state':
                $tags = self::getResourceTypes();
                break;
            case 'vod_version':
                $tags = self::getVersions();
                break;
            default:
                $tags = [''];
        }

        $str = '';
        foreach ($tags as $tag) {
            $str .= '<a href="javascript:;" class="select" data-id="vod-'. $field .'">'. $tag .'</a>&nbsp;&nbsp;';
        }
        return $str;
    }


}