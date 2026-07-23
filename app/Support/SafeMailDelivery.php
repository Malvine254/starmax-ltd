<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Facades\Log;
use Throwable;

class SafeMailDelivery
{
    public static function attempt(Closure $delivery, array $context = []): bool
    {
        try {
            $delivery();

            return true;
        } catch (Throwable $exception) {
            Log::error('Email delivery failed after application data was saved.', [
                ...$context,
                'exception' => $exception::class,
                'error' => $exception->getMessage(),
            ]);

            return false;
        }
    }
}
