<?php

namespace backend\components\event;

use yii\base\Event;
/**
 * Class MailEvent
 * 用于传递邮箱、主题和内容参数给邮件类Mail
 *
 * @package \backend\components\event
 */
class MailEvent extends Event
{
    public $email;
    public $subject;
    public $content;
}