<?php

namespace App\Http\Middleware;

use Closure;

class customerAuth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (auth('customer')->check()) {
			return $next($request);
		}
		return back();
	}
}
