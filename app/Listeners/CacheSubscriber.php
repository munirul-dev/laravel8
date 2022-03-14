<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{
    public function handleCacheHit(CacheHit $event)
    {
        Log::info("Cache hit: {$event->key}");
    }

    public function handleCacheMissed(CacheMissed $event)
    {
        Log::info("Cache missed: {$event->key}");
    }

    public function subscribe($event)
    {
        $event->listen(
            CacheHit::class,
            CacheSubscriber::class . '@handleCacheHit'
        );

        $event->listen(
            CacheMissed::class,
            CacheSubscriber::class . '@handleCacheMissed'
        );
    }
}
