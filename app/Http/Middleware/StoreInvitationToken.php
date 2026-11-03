<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreInvitationToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
    {
        if ($request->filled('invitation')) {
            $request->session()->put(
                'invitation_token',
                $request->query('invitation')
            );
        }

        return $next($request);
    }
}
