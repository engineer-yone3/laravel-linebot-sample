<?php

namespace App\Http\Controllers\Api\Line;

use App\Http\Controllers\Controller;
use App\Services\Event\LineFollowEvent;
use App\Services\Event\LineImageEvent;
use App\Services\Event\LinePostbackEvent;
use App\Services\Event\LineTextEvent;
use App\Services\Event\LineUnfollowEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\FollowEvent;
use LINE\LINEBot\Event\MessageEvent\ImageMessage;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Event\PostbackEvent;
use LINE\LINEBot\Event\UnfollowEvent;
use Throwable;

class LineBotController extends Controller
{
    public function __construct(
        private LineFollowEvent $followEvent,
        private LineUnfollowEvent $unFollowEvent,
        private LineTextEvent $textEvent,
        private LineImageEvent $imageEvent,
        private LinePostbackEvent $postbackEvent
    )
    {
    }

    public function callback(LINEBot $bot, Request $request): JsonResponse
    {
        // Line Signature Check
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);
        if (empty($signature)) {
            return abort(400, 'Bad Request');
        }
        try {
            $events = $bot->parseEventRequest($request->getContent(), $signature);

            foreach ($events as $event) {

                if ($event instanceof FollowEvent) {
                    $this->followEvent->execute($event, $bot);
                } elseif ($event instanceof TextMessage) {
                    $this->textEvent->execute($event, $bot);
                } elseif ($event instanceof ImageMessage) {
                    $this->imageEvent->execute($event, $bot);
                } elseif ($event instanceof PostbackEvent) {
                    $this->postbackEvent->execute($event, $bot);
                } elseif ($event instanceof UnfollowEvent) {
                    $this->unFollowEvent->execute($event);
                }
            }
        } catch (Throwable $th) {
            logger()->error($th->getMessage());
            logger()->error($th->getTraceAsString());
        }
        

        return response()->json('success');
    }
}
