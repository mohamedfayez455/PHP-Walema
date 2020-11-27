<?php

namespace App\Http\Controllers;

class CustomersOrdersController extends Controller {
	/*this function will display all customers orders */
	public function CustomersOrders() {
		return view('customers.orders.orders');
	}
}
