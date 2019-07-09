<?php
namespace frontend\modules\api\models;


class User extends \common\models\User
{

    public function extraFields(){

    }

    public function fields()
    {
        return ['id','username'];
    }

}