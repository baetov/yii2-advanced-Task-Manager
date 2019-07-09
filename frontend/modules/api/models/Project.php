<?php
namespace frontend\modules\api\models;


class Project extends \common\models\Project
{
    public function fields()
    {
        return ['id','title',mb_substr('description',50),'active'];
    }

    public function extraFields()
    {
        return ['tasks'];
    }

}
