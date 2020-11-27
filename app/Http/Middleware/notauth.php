<?php

namespace App\Http\Middleware;

use Closure;

class notauth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (is_supplier() || is_customer()) {

			return redirect('/');

		} else {

			return $next($request);

		}
	}
}
