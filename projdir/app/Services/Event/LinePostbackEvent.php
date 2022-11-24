<?php

namespace App\Services\Event;

use App\Services\Bot\LineApiServiceInterface;
use LINE\LINEBot;
use LINE\LINEBot\Event\PostbackEvent;

class LinePostbackEvent {
    public function __construct(
        private LineApiServiceInterface $service
    )
    {

    }

    public function execute(PostbackEvent $event, LINEBot $bot): void
    {
        $postbackData = $event->getPostbackData();
        if (empty($postbackData)) {
            return;
        }
        parse_str($postbackData, $params);
        $value = $params['value'];

        if (empty($value)) {
            return;
        }
        $this->service->replyText($bot, $event->getReplyToken(), 'send value is 「' . $value . '」');
    }
    
}