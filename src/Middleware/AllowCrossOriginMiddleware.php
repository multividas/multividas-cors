<?php

declare(strict_types=1);

/**
 * (c) 2024 Multividas. All rights reserved.
 * Unauthorized use prohibited.
 * Website: https://www.multividas.com
 */

namespace Multividas\AllowCrossOrigin\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AllowCrossOriginMiddleware
{
    private const ACCESS_CONTROL_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';
    private const ACCESS_CONTROL_ALLOW_CREDENTIALS = 'Access-Control-Allow-Credentials';
    private const ACCESS_CONTROL_ALLOW_METHODS = 'Access-Control-Allow-Methods';
    private const ACCESS_CONTROL_ALLOW_HEADERS = 'Access-Control-Allow-Headers';
    private const ACCESS_CONTROL_EXPOSE_HEADERS = 'Access-Control-Expose-Headers';
    private const ACCESS_CONTROL_MAX_AGE = 'Access-Control-Max-Age';

    private array $configAttributes = [
        'allowed_origins' => self::ACCESS_CONTROL_ALLOW_ORIGIN,
        'allowed_methods' => self::ACCESS_CONTROL_ALLOW_METHODS,
        'allowed_headers' => self::ACCESS_CONTROL_ALLOW_HEADERS,
        'exposed_headers' => self::ACCESS_CONTROL_EXPOSE_HEADERS,
        'supports_credentials' => self::ACCESS_CONTROL_ALLOW_CREDENTIALS,
        'max_age' => self::ACCESS_CONTROL_MAX_AGE
    ];

    private int $options_success_status = 204;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->initializeProperties();

        $response = $next($request);
        $responseHeaders = $response->headers;

        foreach ($this->configAttributes as $configAttribute => $headerName) {
            if (isset($this->$configAttribute)) {
                $responseHeaders->set($headerName, $this->formatHeaderValue($this->$configAttribute));
            }
        }

        $request->getMethod() === "OPTIONS" && $response->setStatusCode($this->options_success_status);

        return $response;
    }

    /**
     * Method initializeProperties
     *
     * @return void
     */
    private function initializeProperties(): void
    {
        $config = App::make('config')->get('multividas-cors');

        foreach (array_keys($this->configAttributes) as $configAttribute) {
            if (isset($config[$configAttribute]) &&
                in_array(gettype($config[$configAttribute]), ['integer', 'boolean', 'array'])) {
                $this->$configAttribute = $config[$configAttribute];
            }
        }

        if (isset($config['options_success_status']) &&
            'integer' === gettype($config['options_success_status'])) {
            $this->options_success_status = (int) $config['options_success_status'];
        }
    }

    /**
     * Method formatHeaderValue
     *
     * @param mixed $value
     *
     * @return string
     */
    private function formatHeaderValue(mixed $value): string
    {
        if (is_array($value)) {
            return implode(', ', $value);
        } elseif (is_int($value)) {
            return (string) $value;
            ;
        } elseif (is_bool($value)) {
            return (bool) $value ? "true" : "false";
        }
    }
}
