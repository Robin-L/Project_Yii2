<?php

namespace backend\components;

use Yii;
/**
 * Class Mail
 *
 * @package \backend\components
 */
class Mail
{
    public static function sendMail($event)
    {
        $mail = Yii::$app->mailer->compose();
        $mail->setTo($event->email);
        $mail->setSubject($event->subject);
        $mail->setTextBody($event->content);
        return $mail->send();
    }
}