<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Propaga un identificador de correlación para soporte y trazabilidad en logs.
 */
class AssignRequestId
{
    public function handle(Request $request, Closure $next): Response
    {
        $requestId = $request->headers->get('X-Request-Id');
        if (! is_string($requestId) || $requestId === '') {
            $requestId = (string) Str::uuid();
        }

        $request->headers->set('X-Request-Id', $requestId);
        $request->attributes->set('request_id', $requestId);

        Log::withContext([
            'request_id' => $requestId,
        ]);

        /** @var Response $response */
        $response = $next($request);
        $response->headers->set('X-Request-Id', $requestId);

        return $response;
    }
}
