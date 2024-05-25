<?php

declare(strict_types=1);

/**
 * (c) 2024 Multividas. All rights reserved.
 * Unauthorized use prohibited.
 * Website: https://www.multividas.com
 */

namespace Multividas\AllowCrossOrigin\Providers;

use Illuminate\Support\ServiceProvider;
use Multividas\AllowCrossOrigin\Middleware\AllowCrossOriginMiddleware;
use Multividas\AllowCrossOrigin\Interfaces\AllowCrossOriginInterface;

class AllowCrossOriginServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            $this->basePath('config/multividas-cors.php') => base_path('config/multividas-cors.php')
        ], 'multividas-cors-config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom($this->basePath('config/multividas-cors.php'), 'multividas-cors');

        $this->app->bind(AllowCrossOriginInterface::class, function () {
            return new AllowCrossOriginMiddleware();
        });
    }

    protected function basePath($path = ""): string
    {
        return __DIR__ . '/../../' . $path;
    }
}
