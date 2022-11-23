<?php

namespace App\Services\Event;

use App\Services\Bot\LineApiServiceInterface;
use LINE\LINEBot;
use LINE\LINEBot\Event\MessageEvent\ImageMessage;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineImageEvent {
    public function __construct(
        private LineApiServiceInterface $service
    )
    {

    }

    public function execute(ImageMessage $event, LINEBot $bot): void
    {
        $contentProvider = $event->getContentProvider();

        if ($contentProvider->isExternal()) {
            $imageMessage = new ImageMessageBuilder(
                $contentProvider->getOriginalContentUrl(),
                $contentProvider->getPreviewImageUrl()
            );
            $textMessage = new TextMessageBuilder('送られた画像はこちらです');
            $messages = new MultiMessageBuilder([$textMessage, $imageMessage]);
            $this->service->replyMessage($bot, $event->getReplyToken(), $messages);
        }
    }
}