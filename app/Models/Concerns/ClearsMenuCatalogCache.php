<?php

namespace App\Models\Concerns;

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Cache;

trait ClearsMenuCatalogCache
{
    /**
     * Invalidate cached public catalog whenever categories or products change.
     */
    protected static function bootClearsMenuCatalogCache(): void
    {
        $flush = static function (): void {
            Cache::forget(MenuController::CATALOG_CACHE_KEY);
        };

        static::saved($flush);
        static::deleted($flush);
    }
}
