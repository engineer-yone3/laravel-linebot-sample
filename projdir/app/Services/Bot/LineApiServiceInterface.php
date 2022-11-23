<?php

namespace App\Services\Bot;

use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\Response;

interface LineApiServiceInterface {

    public function getProfile(LINEBot $bot, string $userId): Response;
    public function replyText(LINEBot $bot, string $replyToken, string $text, ?array $extraTexts = null): Response;
    public function replyMessage(LINEBot $bot, string $replyToken, MessageBuilder $message): Response;
}