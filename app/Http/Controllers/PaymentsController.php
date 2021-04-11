<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Payment;
use App\Tax;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $payments = Payment::all();
        
        return view('main.payments.index')->with(['payments'=>$payments]);
    }

    public function show_edit_payment($id)
    {
        $payment = Payment::find($id);
        $beneficiaries = Beneficiary::all();
        $taxes = Tax::all();

        return view('main.payments.edit_payment')->with(['payment'=>$payment, 'beneficiaries'=> $beneficiaries, 'taxes'=> $taxes]);
    }
}
