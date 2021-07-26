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
        // $beneficiaries = Beneficiary::all();
        $benTax = Beneficiary::where('tag', '=', "tax")->get();
        $beneficiaries = Beneficiary::where('tag', '!=', "tax")->get();
        $tax = Tax::all();
        $budgets = Budget::all();


        return view('main.voucher.payment_cache')
            ->with([
                'payment' => $payment,
                'taxes' => $tax,
                'beneficiaries' => $beneficiaries,
                'benTax' => $benTax,
                'budgets' => $budgets,
            ]);
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
            'budget' => "Int",
            'benTax' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect('/create_voucher')
                ->withErrors($validator)
                ->withInput();
        }

        // if (is_array($request->tax) > 0) {
        //     dd($request->tax);
        // } else {
        //     dd($request->tax);
        // }

        $tax = 0;

        if (!$request->tax) {
            $amount = $request->amount;
            $tax_amount = 0;
        } else {
            foreach ($request->tax as $t) {
                $tax_db = Tax::find($t);
                $tax = $tax + $tax_db->percentage;
            }
            // dd($tax);
            // $tax = Tax::find($request->tax);
            // $tax_value = $tax->percentage;
            $a = $request->amount;
            $a = ($a / 100) * $tax;
            $amount = $request->amount - $a;
            $tax_amount = $a;
        }
        // dd($tax_amount);

        $cart = new PaymentCart($prevPayment);

        $arrayToInsert = [
            "beneficiary" => $request->beneficiary,
            "amount" => $amount,
            "r_amount" => $request->amount,
            "description" => $request->description,
            "tax" => $request->tax,
            "tax_p" => $tax,
            "budget" => $request->budget,
            "tax_amount" => $tax_amount,
            "ben_tax" => $request->benTax,
        ];

        if ($prevPayment) {
            // if (array_key_exists($arrayToInsert['beneficiary'], $prevPayment->payments)) {
            //     return redirect('/create_voucher')->with(['errors' => "[Beneficiary already exists in the voucher List!]"]);
            // }
            $totalAmount = $prevPayment->totalAmount + $amount;
            $total_tax_amount = $prevPayment->total_tax_amount + $tax_amount;
        } else {
            $totalAmount = $amount;
            $total_tax_amount = $tax_amount;
        }

        if ($request->budget) {
            //checking amount in payments table
            $payments = Payment::where('budget_id', '=', $request->budget)->get();
            $amount_r = [];
            foreach ($payments as $p) {
                // $amount_p = $amount_p + $p->amount; 
                array_push($amount_r, $p->amount);
            }
            $amount_p = 0;
            for ($i = 0; $i < count($amount_r); $i++) {
                $amount_p = $amount_p + $amount_r[$i];
            }

            $t_Amount = $totalAmount + $amount_p;

            $budget = Budget::find($request->budget);
            if ($t_Amount > $budget->amount) {
                return redirect('/create_voucher')->with(['errors' => " Sorry you have reached your maximum Budget For this year. Please Increase your budget to get this done!"]);
            }
        } else {
            return redirect('/create_voucher')->with(['errors' => " Sorry Budget not found. Make sure you have Added budget to the system!"]);
        }


        $cart->addToPayment($arrayToInsert['beneficiary'], $arrayToInsert);

        // $request->session()->put('payments', $cart);
        Cache::put('payments', $cart, 2592000);

        // dd($t_Amount);
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
                    'totalamount' => $payments->totalAmount * 100,
                ]);

                if ($payments->total_tax_amount != 0) {
                    # code...
                    $tax_totalamount = $payments->total_tax_amount;

                    $tax_ex = $ex + 1;
                    $tax_split = str_split($tax_ex, 4);
                    $tax_pvno = $tax_split[0] . '/' . $tax_split[1];

                    $new_tax_voucher = Voucher::create([
                        'pvno' => $tax_pvno,
                        'totalamount' => $tax_totalamount * 100,
                    ]);
                }
            } else {
                $year = 20. . date('y');
                $no = '/0001';
                $pvno = $year . $no;

                $newVoucher = Voucher::create([
                    'pvno' => $pvno,
                    'totalamount' => $payments->totalAmount * 100,
                ]);

                if ($payments->total_tax_amount != 0) {
                    # code...
                    $tax_totalamount = $payments->total_tax_amount;

                    // dd()
                    $tax_ex = (int) str_replace('/', '', $pvno) + 1;
                    $tax_split = str_split($tax_ex, 4);
                    $tax_pvno = $tax_split[0] . '/' . $tax_split[1];

                    $new_tax_voucher = Voucher::create([
                        'pvno' => $tax_pvno,
                        'totalamount' => $tax_totalamount * 100,
                    ]);
                }
            }

            foreach ($payments->payments as $payment) {
                $tax_percent = $payment['data']['tax_p'];
                $beneficiary_id = (int)$payment['data']['beneficiary'];
                $budget_id = (int)$payment['data']['budget'];

                $paymentArrayy = [
                    'amount' => $payment['data']['amount'] * 100,
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

                DB::table('payments')->where('id', '=', $newPayment->id)->update(['budget_id' => $budget_id, 'approve' => 0, 'tax_percent' => $tax_percent,]);


                if (is_array($payment['data']['tax']) > 0) {
                    # code...
                    $taxes = $payment['data']['tax'];

                    foreach ($taxes as $tax) {
                        $tax_db_b = Tax::find((int)$tax);
                        $ben_t = Beneficiary::find((int)$payment['data']['ben_tax'][(int)$tax]);

                        $r_a = $payment['data']['r_amount'];
                        $r_a = ($r_a / 100) * $tax_db_b->percentage;

                        $tax_amount = $r_a * 100;
                        $ben_id = (int)$payment['data']['ben_tax'][(int)$tax];
                        $taxPaymentArray = [
                            'amount' => $tax_amount,
                            'description' => 'Tax',
                            'voucher_id' => $new_tax_voucher->id,
                            'beneficiary_id' => $ben_id,
                            'duedate' => date('d/m/y'),
                            'budget_id' => 0,
                            'tax_percent' => 0,
                            'approve' => 0,
                        ];

                        $new_tax_payment = Payment::create($taxPaymentArray);

                        DB::table('payments')
                            ->where('id', '=', $new_tax_payment->id)
                            ->update([
                                'budget_id' => 0,
                                'approve' => 0,
                                'tax_percent' => 0,
                            ]);
                    }
                }
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
        } else {
            $is_approved = 0;
        }
        // dd($is_approved->approve);

        return view('main.voucher.single_voucher')->with(['payments' => $payments, "voucher" => $voucher, "is_approved" => $is_approved]);
    }
}
