<?php

namespace backend\models;


use Yii;
use backend\components\MyRedis;

/**
 * This is the model class for table "mac".
 *
 * @property string $MAC mac地址
 * @property string $SN sn码
 * @property int $use_flag 是否可用
 * @property string $ver 版本
 * @property string $regtime 注册时间
 * @property string $logintime 登录时间
 * @property int $type 类型
 * @property string $duetime 过期时间
 * @property string $contract_time 有效期
 */
class Mac extends \yii\db\ActiveRecord
{
    const NOT_ACTIVE = 0;
    const NORMAL     = 1;
    const EXPIRED    = 2;
    const FORBIDDEN  = 3;

    public $client_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mac';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MAC', 'ver'], 'required'],
            [['use_flag', 'type'], 'integer'],
            [['regtime', 'logintime', 'duetime'], 'safe'],
            [['MAC', 'SN'], 'string', 'max' => 64],
            [['ver'], 'string', 'max' => 255],
            [['contract_time'], 'string', 'max' => 8],
            [['MAC', 'SN'], 'unique', 'targetAttribute' => ['MAC', 'SN']],
            [['MAC'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MAC' => 'mac地址',
            'SN' => 'sn码',
            'use_flag' => '是否可用',
            'ver' => '版本',
            'regtime' => '注册时间',
            'logintime' => '登录时间',
            'type' => '类型',
            'duetime' => '过期时间',
            'contract_time' => '有效期',
            'client_name' => '所属客户'
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $logs = $this->getRenewLog()->all();
            foreach ($logs as $log) {
                $log->delete();
            }
        }
        return true;
    }

    public static function getUseFlagList()
    {
        return [
           self::NOT_ACTIVE => '未激活',
           self::NORMAL     => '可用',
           self::EXPIRED    => '过期',
           self::FORBIDDEN  => '禁用'
        ];
    }

    public function getUseFlag($index)
    {
        $list = self::getUseFlagList();
        return $list[$index];
    }

    public function getUseFlagWithLabel($index)
    {
        $value = $this->getUseFlag($index);
        $labels = ['default', 'info', 'warning', 'danger'];
        $label = $labels[$index];
        return "<label class='label label-{$label}'>{$value}</label>";
    }

    public function getDetail()
    {
        return $this->hasOne(MacDetail::className(), ['MAC' => 'MAC']);
    }

    public function getOnLine()
    {
        $redis = MyRedis::init(MyRedis::REDIS_DEVICE_STATUS);

        return $redis->hget($this->MAC, 'token') ? true : false;
    }

    public function getOnlineWithLabel()
    {
        $value = $this->getOnLine();
        $label = $value ? ['info', '在线'] : ['default', '离线'];

        return "<label class='label label-{$label[0]}'>{$label[1]}</label>";
    }

    public function getRenewLog()
    {
        return $this->hasOne(RenewLog::className(),['mac' => 'MAC']);
    }

    public static function exportCSV($data)
    {
        $str = "MAC,SN\n";
        $str = iconv('utf-8','gb2312',$str);

        foreach ($data as $v) {
            $MAC = iconv('utf-8','gb2312',$v->MAC); //中文转码
            $SN = iconv('utf-8','gb2312',$v->SN);
            $str .= "\t".$MAC.","."\t".$SN."\n";
        }

        $filename = date('Ymd').'.csv'; //设置文件名
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        return $str;
    }
}