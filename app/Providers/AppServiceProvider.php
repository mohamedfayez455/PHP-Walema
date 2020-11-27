<?php

namespace App\Providers;

use Config;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Schema::defaultStringLength(191);
		Schema::enableForeignKeyConstraints();
		Config::set('filesystems.disks.public.url', url('storage'));
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {

	}
}
