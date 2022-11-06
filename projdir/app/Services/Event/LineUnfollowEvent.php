<?php

namespace App\Services\Event;

use App\Models\LineFriend;
use App\Services\Bot\LineApiServiceInterface;
use Illuminate\Support\Facades\DB;
use LINE\LINEBot\Event\UnfollowEvent;
use Throwable;

class LineUnfollowEvent {

    public function __construct(
        private LineApiServiceInterface $service
    )
    {

    }

    public function execute(UnfollowEvent $event): void
    {
        try {
            DB::beginTransaction();

            LineFriend::where('line_id', $event->getUserId())->delete();

            DB::commit();
        } catch (Throwable $th) {
            logger()->error('友達解除中にエラーが発生しました');
            logger()->error($th->getMessage());
            DB::rollback();
        }
    }
}