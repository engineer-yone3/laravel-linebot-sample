<?php

namespace App\Services\Bot;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\Response;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

final class LineApiServiceStub implements LineApiServiceInterface {


    public function getProfile(LINEBot $bot, string $userId): Response
    {
        $data = [
            'displayName' => 'やまだたろう',
            'pictureUrl' => 'https::/www.example.com/test.jpg',
            'statusMessage' => 'テストです'
        ];
        return new Response(HttpFoundationResponse::HTTP_OK, json_encode($data));
    }

    public function replyMessage(LINEBot $bot, string $replyToken, MessageBuilder $message): Response
    {
        logger()->debug('Input Reply Token: ' . $replyToken);
        logger()->debug('Input Message: ' . print_r($message, true));
        return new Response(HttpFoundationResponse::HTTP_OK, null);
    }

    public function replyText(LINEBot $bot, string $replyToken, string $text, ?array $extraTexts = null): Response
    {
        logger()->debug('Input Reply Token: ' . $replyToken);
        logger()->debug('Input Text: ' . $text);
        if (!empty($extraTexts)) {
            logger()->debug('Input Extra Texts: ' . print_r($extraTexts, true));
        }
        return new Response(HttpFoundationResponse::HTTP_OK, null);
    }
}