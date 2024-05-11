<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HandleTransactions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        DB::beginTransaction();

        try {
            $response = $next($request);
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Transaction failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred, transaction rolled back.'], 500);
        }
    }
}
