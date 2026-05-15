<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAudit
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if ($request->user() && $request->method() !== 'GET') {
            AuditLog::create([
                'user_id' => $request->user()->id,
                'action' => $request->method().' '.$request->path(),
                'model_type' => null,
                'model_id' => null,
                'old_values' => null,
                'new_values' => null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }
    }
}
