<?php

namespace App\Services\Event;

use App\Models\LineFriend;
use App\Services\Bot\LineApiServiceInterface;
use Illuminate\Support\Facades\DB;
use LINE\LINEBot;
use LINE\LINEBot\Event\FollowEvent;
use Throwable;

class LineFollowEvent {

    public function __construct(
        private LineApiServiceInterface $service
    )
    {

    }

    public function follow(FollowEvent $event, LINEBot $bot): void
    {
        $lineId = $event->getUserId();
        $user = LineFriend::where('line_id', $lineId)->firstOrNew();
        try {
            DB::beginTransaction();
            $response = $this->service->getProfile($bot, $lineId);

            if ($response->isSucceeded()) {
                $profile = $response->getJSONDecodedBody();

                $user->line_id = $lineId;
                $user->line_name = !empty($profile['displayName']) ? $profile['displayName'] : null;
                $user->line_icon_url = !empty($profile['pictureUrl']) ? $profile['pictureUrl'] : null;
                $user->save();

                DB::commit();
                $this->service->replyText($bot, $event->getReplyToken(), '友達登録ありがとうございます！');
            }
        } catch (Throwable $th) {
            logger()->error('友達登録中にエラーが発生しました');
            logger()->error($th->getMessage());
            DB::rollback();
        }
    }
}