<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;

class HandleCsrfError
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            // Log the error for debugging
            Log::warning('CSRF Token Mismatch detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
            ]);

            // If it's an AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Session expired. Please refresh the page.',
                    'error' => 'token_mismatch'
                ], 419);
            }

            // For regular requests, redirect back with error message
            return redirect()->back()
                ->withInput($request->except('_token', '_method'))
                ->with('error', 'Session telah berakhir. Silakan coba lagi.');
        }
    }
}
