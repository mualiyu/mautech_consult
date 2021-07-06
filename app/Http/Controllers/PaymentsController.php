<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Payment;
use App\Tax;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

   

    
    public function delete_payment($id)
    {
        $del_payment = Payment::destroy($id);

        if(!$del_payment){
            return redirect()->route('payments')->with(["error"=>"System Can't delete Payment Now! Try Later."]);
        }

        return redirect()->route('payments')->with(['message' =>"Payment is deleted."]);

    }

    public function update_payment(Request $request, $id)
    {
        $voucher = Voucher::find($id);

        $payments = Payment::where("voucher_id", "=", $voucher->id)->get();

        foreach ($payments as $payment) {
            // Payment::where('id', '=', $payment->id)->updated(['approve'=>1]);
            DB::table('payments')->where('id', '=',$payment->id)->update(['approve'=>1]);
        }

        return redirect("/vouchers")->with(["errors"=>"Voucher ".$voucher->pvno." is Approved"]);
    }
}
