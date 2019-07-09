<?php
/**
 * Created by IntelliJ IDEA.
 * User: ahmad
 * Date: 06.06.2019
 * Time: 5:00
 */

namespace common\services;


use yii\base\Component;


class EmailService extends Component
{
    public function send($to, $subject, $views, $data)
    {
        \Yii::$app
            ->mailer
            ->compose($views, $data)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . 'robot'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}