<?php

namespace App\Services\Event;

use App\Services\Bot\LineApiServiceInterface;

class LinePostbackEvent {
    public function __construct(
        private LineApiServiceInterface $service
    )
    {

    }
    
}