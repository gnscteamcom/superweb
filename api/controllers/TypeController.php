<?php
/**
 * Created by PhpStorm.
 * User: lychee
 * Date: 2018/4/22
 * Time: 11:17
 */

namespace api\controllers;


use common\models\VodList;
use yii\rest\ActiveController;

class TypeController extends ActiveController
{

    public $modelClass = 'common\models\VodList';

    public function actions()
    {
        $actions =  parent::actions(); // TODO: Change the autogenerated stub
        unset($actions['index']);
    }

    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $data = VodList::find()
                   ->orderBy('list_sort asc')
                   ->all();
        return $data;
    }
}