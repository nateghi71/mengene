<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RandomLink;

class CheckRandomLinkExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->route('token');
        $type = $request->route('type');

        $randomLink = RandomLink::where('token', $token)->where('type', $type)->first();

        if (!$randomLink) {
            abort(403, 'لینک وارد شده اشتباه است'); // Link not found or expired
        } else {
            if (Carbon::now()->gt($randomLink->expires_at)) {
                abort(403, 'زمان لینک شما منقضی شده است'); // Link not found or expired
            }
        }

        return $next($request);
    }
}
