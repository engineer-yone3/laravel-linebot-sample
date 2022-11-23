<?php

namespace App\Services\Bot;

use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\Response;

final class CustomLineBotImpl implements LineApiServiceInterface {

    public function getProfile(LINEBot $bot, string $userId): Response
    {
        return $bot->getProfile($userId);
    }

    public function replyMessage(LINEBot $bot, string $replyToken, MessageBuilder $message): Response
    {
        return $bot->replyMessage($replyToken, $message);
    }

    public function replyText(LINEBot $bot, string $replyToken, string $text, ?array $extraTexts = null): Response
    {
        return $bot->replyText($replyToken, $text, $extraTexts);
    }

}