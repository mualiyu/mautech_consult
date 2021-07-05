<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mandate;
use App\Voucher;
use App\Payment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
	    $mandates = Mandate::latest()->take(10)->get();
	    $vouchers = Voucher::latest()->take(10)->get();
	    $payments = Payment::latest()->take(10)->get();
        return view('main.dashboard', compact("mandates", "vouchers", "payments"));
    }
}
