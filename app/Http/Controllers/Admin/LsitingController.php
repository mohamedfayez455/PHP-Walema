<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ListingDatatable;

class LsitingController extends Controller
{
	public function index(ListingDatatable $listingDatatable)
	{
		return $listingDatatable->render('admin.listings.index', ['title' => 'listing']);
	}
}
