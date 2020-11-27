<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuppliersOrdersController extends Controller
{
  /*this function will display all suplliers orders */
  public function suppliersorders()
  {
    return view ('suppliers.orders.orders');
  }
}
