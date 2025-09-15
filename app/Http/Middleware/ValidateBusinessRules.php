<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ValidateBusinessRules
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->has(['date', 'time'])) {
            $bookingDateTime = Carbon::parse($request->date . ' ' . $request->time);
            if ($bookingDateTime->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot make bookings for past times'
                ], 422);
            }
        }

        return $next($request);
    }
}
