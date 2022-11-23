<?php

namespace App\Services\Event;

class LinePostbackEvent {
    public function __construct(
        private LineApiServiceInterface $service
    )
    {

    }
    
}