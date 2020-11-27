<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\ApiResponse;
use Closure;

class AppMiddleware {
	use ApiResponse;
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (!auth('api')->check()) {
			$this->unauthenticated();
		}

		return $next($request);
	}
}
