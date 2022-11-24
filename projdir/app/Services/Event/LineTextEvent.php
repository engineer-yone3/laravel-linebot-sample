<?php

namespace App\Services\Event;

use LINE\LINEBot;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use App\Services\Bot\LineApiServiceInterface;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;

class LineTextEvent {
    public function __construct(
        private LineApiServiceInterface $service
    )
    {

    }

    public function execute(TextMessage $event, LINEBot $bot): void
    {
        $sendText = $event->getText();
        if ($sendText === 'postback1') {
            $this->sendQuestion($bot, $event->getReplyToken());
        } elseif ($sendText === 'postback2') {
            $this->sendQuickReply($bot, $event->getReplyToken());
        } else {
            $this->service->replyText($bot, $event->getReplyToken(), $event->getText());
        }
    }

    private function sendQuestion(LINEBot $bot, string $replyToken): void
    {
        $button1 = new PostbackTemplateActionBuilder('send 「A」', 'value=a');
        $button2 = new PostbackTemplateActionBuilder('send 「B」', 'value=b');
        $buttonBuilder = new ButtonTemplateBuilder(null, 'choose 「A」or「B」', null, [$button1, $button2]);
        $builder = new TemplateMessageBuilder('choose 「A」or「B」', $buttonBuilder);
        $this->service->replyMessage($bot, $replyToken, $builder);
    }

    private function sendQuickReply(LINEBot $bot, string $replyToken): void
    {
        $button1 = new QuickReplyButtonBuilder(new PostbackTemplateActionBuilder('send 「A」', 'value=a'));
        $button2 = new QuickReplyButtonBuilder(new PostbackTemplateActionBuilder('send 「B」', 'value=b'));
        $builder = new QuickReplyMessageBuilder([$button1, $button2]);
        $bot->replyMessage($replyToken, new TextMessageBuilder('choose 「A」or「B」', $builder));
    }
}