<?php

namespace App\Services\Event;

use LINE\LINEBot;
use LINE\LINEBot\Event\MessageEvent\TextMessage;

class LineTextEvent {
    public function __construct(
        private LineApiServiceInterface $service
    )
    {

    }

    public function execute(TextMessage $event, LINEBot $bot): void
    {
        $this->service->replyText($bot, $event->getReplyToken(), $event->getText());
    }
}