<?php

namespace backend\controllers;

use backend\components\event\MailEvent;
use Yii;
use yii\web\Controller;
/**
 * Class SendMailController
 *
 * @package \backend\controllers
 */
class SendMailController extends Controller
{
    const SEND_MAIL = 'send_mail';
    public function init()
    {
        parent::init();
        // 绑定邮件类，当事件触发的时候，调用邮件类Mail
        $this->on(self::SEND_MAIL, ['backend\components\Mail', 'sendMail']);
    }

    public function actionSend()
    {
        // 触发邮件事件
        $event = new MailEvent();
        $event->email = '186******42@sina.cn';
        $event->subject = '事件邮件测试';
        $event->content = '事件邮件内容';

        $this->trigger(self::SEND_MAIL, $event);
    }
}