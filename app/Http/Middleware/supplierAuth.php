<?php

namespace App\Http\Middleware;

use Closure;

class supplierAuth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (auth()->guard('supplier')->check()) {
			return $next($request);
		}
		return back();

	}
}
