<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$response = $next($request);

    	if ($request->hasHeader('X-Refresh-Token')) {
    		$user = Auth::user();
    		if ($user) {
    			$token = $user->token();
    			if ($token) {
    				$token->forceDelete();
    				$newToken = $user->createToken('webapp', ['*']);
    				$response->headers->set('X-New-Token', $newToken->accessToken);
					$response->headers->set('X-New-Token-Expires', $newToken->token->expires_at->toISOString());
				}
			}
		}

        return $response;
    }
}
