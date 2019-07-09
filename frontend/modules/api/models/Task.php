<?php
namespace frontend\modules\api\models;


class Task extends \common\models\Task
{
    public function fields()
    {
        return ['id','title','description'];
    }

    public function extraFields()
    {
        return ['projects'];
    }

}