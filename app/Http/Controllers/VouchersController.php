<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Budget;
use App\Payment;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\PaymentCart;
use App\Tax;
use Facade\FlareClient\Time\Time;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class VouchersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vouchers = Voucher::all();
        $beneficiaries = Beneficiary::all();
        $tax = Tax::all();

        return view('main.voucher.index')->with(['vouchers' => $vouchers, 'taxes' => $tax, 'beneficiaries' => $beneficiaries]);
    }

    public function show_create_voucher()
    {

        // Cache::forget("payments");
        $payment = Cache::get("payments");
        // dd($payment);
        $beneficiaries = Beneficiary::all();
        $tax = Tax::all();
        $budgets = Budget::all();


        return view('main.voucher.payment_cache')->with(['payment' => $payment, 'taxes' => $tax, 'beneficiaries' => $beneficiaries, 'budgets' => $budgets]);
    }



    public function create_payments(Request $request)
    {
        // $prevPayment = $request->session()->get('payments');
        $prevPayment = Cache::get('payments');
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'beneficiary' => 'Int',
            'amount' => '',
            'description' => 'String',
            'tax' => "nullable",
            'budget' => "Int"
        ]);

        if ($validator->fails()) {
            return redirect('/create_voucher')
            ->withErrors($validator)
            ->withInput();
        }


        $tax = 0;

        if(!$request->tax){
            $amount = $request->amount;
        }else{
            foreach($request->tax as $t){
                $tax_db = Tax::find($t);
                $tax = $tax + $tax_db->percentage;
            }
            // dd($tax);
            // $tax = Tax::find($request->tax);
            // $tax_value = $tax->percentage;
            $a = (int)$request->amount;
            $a = ($a/100) * $tax; 
            $amount = $request->amount - $a;

        }
        // dd($amount);

        $cart = new PaymentCart($prevPayment);

        $arrayToInsert = [
            "beneficiary" => $request->beneficiary,
            "amount" => $amount,
            "description" => $request->description,
            "tax" => $tax,
            "budget" => $request->budget
        ];

        if ($prevPayment) {
            if (array_key_exists($arrayToInsert['beneficiary'], $prevPayment->payments)) {
                return redirect('/create_voucher')->with(['errors' => "[Beneficiary already exists in the voucher List!]"]);
            }
            $totalAmount = $prevPayment->totalAmount + $amount;
        }else{
            $totalAmount = $amount;
        }

        if($request->budget){
            //checking amount in payments table
            $payments = Payment::where('budget_id', '=', $request->budget)->get();
            $amount_r = [];
            foreach ($payments as $p) {
                // $amount_p = $amount_p + $p->amount; 
                array_push($amount_r, $p->amount);
            }
            $amount_p = 0; 
            for ($i=0; $i < count($amount_r); $i++) { 
                $amount_p = $amount_p + $amount_r[$i];
            }

            $t_Amount = $totalAmount+$amount_p;

            $budget = Budget::find($request->budget);
            if ($t_Amount > $budget->amount) {
                return redirect('/create_voucher')->with(['errors' => " Sorry you have reached your maximum Budget For this year. Please Increase your budget to get this done!"]);
            }
        }else{
            return redirect('/create_voucher')->with(['errors' => " Sorry Budget not found. Make sure you have Added budget to the system!"]);
        }

        // dd($t_Amount);

        $cart->addToPayment($arrayToInsert['beneficiary'], $arrayToInsert);

        // $request->session()->put('payments', $cart);
        Cache::put('payments', $cart, 2592000);

        // $payments = Cache::put("payments", $arrayToInsert, "3600");

        return redirect('/create_voucher')->with(['errors' => "Payment is added to cache memory!"]);
    }



    public function delete_payment_from_local(Request $request, $id)
    {

        $payments = Cache::pull('payments');

        // dd($payments);
        if (array_key_exists($id, $payments->payments)) {
            unset($payments->payments[$id]);
        }

        $newPayment = new PaymentCart($payments);

        $newPayment->updateTotalAmount();

        // $request->session()->put("payments", $newPayment);
        Cache::put('payments', $newPayment, 2592000);

        return Redirect::to('/create_voucher')->with(['messages' => "One Payment is removed from cache!"]);
    }

    public function create_voucher_and_payments(Request $request)
    {

        $payments = Cache::get('payments');

        if ($payments) {
            $vouchers = Voucher::count();

            if ($vouchers != 0) {
                $lastVoucher = DB::table('vouchers')->orderBy('id', 'DESC')->first();

                $ex = (int) str_replace('/', '', $lastVoucher->pvno) + 1;
                $split = str_split($ex, 4);
                $pvno = $split[0] . '/' . $split[1];

                $newVoucher = Voucher::create([
                    'pvno' => $pvno,
                    'totalamount' => $payments->totalAmount,
                ]);
            } else {
                $year = 20. . date('y');
                $no = '/0001';
                $pvno = $year . $no;

                $newVoucher = Voucher::create([
                    'pvno' => $pvno,
                    'totalamount' => $payments->totalAmount,
                ]);
            }

            foreach ($payments->payments as $payment) {
                $tax_percent = $payment['data']['tax'];
                $beneficiary_id = (int)$payment['data']['beneficiary'];
                $budget_id = (int)$payment['data']['budget'];

                $paymentArrayy = [
                    'amount' => $payment['data']['amount'],
                    'description' => $payment['data']['description'],
                    'voucher_id' => $newVoucher->id,
                    'beneficiary_id' => $beneficiary_id,
                    'duedate' => date('d/m/y'),
                    'budget_id' => $budget_id,
                    'tax_percent' => $tax_percent,
                    'approve' => 0,
                ];
                //dd($paymentArray);

                $newPayment = Payment::create($paymentArrayy);

                DB::table('payments')->where('id', '=', $newPayment->id)->update(['budget_id'=>$budget_id, 'approve' => 0, 'tax_percent' => $tax_percent,]);

            }

            Cache::forget('payments');

            return redirect()->route('show_single_voucher', ['id' => $newVoucher->id])->with(['message' => 'Voucher is added Successfully']);
        } else {
            return redirect('/create_voucher')->with(['errors' => 'No Payment in voucher']);
        }
    }


    public function delete_voucher_db($id)
    {
        $voucher = Voucher::find($id);

        $payments = DB::table('payments')->where('voucher_id', '=', $voucher->id)->get();
        $mandates = DB::table('mandates')->where('voucher_id', '=', $voucher->id)->get();

        if ($payments->count() > 0) {
            foreach ($payments as $payment) {
                DB::table('payments')->delete($payment->id);
            }
        }
        if ($mandates->count() > 0) {
            foreach ($mandates as $mandate) {
                DB::table('mandates')->delete($mandate->id);
            }
	}
	Cache::forget("mandates");

        DB::table('vouchers')->delete($id);

        return redirect('/vouchers')->with(['errors' => 'Voucher is deleted']);
    }

    public function show_single_voucher($id)
    {
        $voucher = Voucher::find($id);
        $payments = DB::table('payments')->where('voucher_id', '=', $id)->get();
        $is_approve = Payment::where('voucher_id', '=', $id)->first();
        if ($is_approve) {
            $is_approved = $is_approve->approve;
        }else{
            $is_approved = 0;
        }
        // dd($is_approved->approve);

        return view('main.voucher.single_voucher')->with(['payments' => $payments, "voucher" => $voucher, "is_approved" => $is_approved]);
    }
}
