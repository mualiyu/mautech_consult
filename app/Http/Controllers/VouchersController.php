<?php

namespace App\Http\Controllers;

use App\Beneficiary;
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

        return view('main.voucher.index')->with(['vouchers'=>$vouchers,'taxes'=>$tax, 'beneficiaries'=>$beneficiaries]);
    }

    public function show_create_voucher()
    {

        $payment = Cache::get("payments");
        // dd($payment);
        $beneficiaries = Beneficiary::all();
        $tax = Tax::all();
        
        
        return view('main.voucher.payment_cache')->with(['payment'=>$payment,'taxes'=>$tax, 'beneficiaries'=>$beneficiaries]);
    }

    public function create_payments(Request $request)
    {
        // $prevPayment = $request->session()->get('payments');
        $prevPayment = Cache::get('payments');
        
        $validator = Validator::make($request->all(), [
            'beneficiary'=>'Int',
            'amount'=>'Int',
            'description'=>'String',
            'tax' => "Int|nullable",
        ]);

        $cart = new PaymentCart($prevPayment);
        
        $arrayToInsert = [
            "beneficiary" => $request->beneficiary,
            "amount" => $request->amount,
            "description" => $request->description,
            "tax" => $request->tax,
        ];
        if ($prevPayment) {
            if (array_key_exists($arrayToInsert['beneficiary'], $prevPayment->payments)) {
                return redirect('/create_voucher')->with(['errors'=>"Beneficiary already exists in the voucher List!"]);
            }
        }

        $cart->addToPayment($arrayToInsert['beneficiary'], $arrayToInsert);

        // $request->session()->put('payments', $cart);
        Cache::put('payments', $cart, 2592000);

        // $payments = Cache::put("payments", $arrayToInsert, "3600");

        return redirect('/create_voucher')->with(['messages'=>"Payment is added to cache memory!"]);

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

        return redirect('/create_voucher')->with(['messages'=>"One Payment is removed from cache!"]);
    }

    public function create_voucher_and_payments(Request $request)
    {
        
        $payments = Cache::get('payments');

        if($payments){
            $vouchers = Voucher::count();
            
            if ($vouchers != 0) {
                $lastVoucher = DB::table('vouchers')->orderBy('id', 'DESC')->first();

                $ex = (Int) str_replace('/','', $lastVoucher->pvno) + 1;
                $split = str_split($ex, 4);
                $pvno = $split[0].'/'.$split[1];

                $newVoucher = Voucher::create([
                    'pvno'=>$pvno,
                    'totalamount'=> $payments->totalAmount,
                ]);

                
            }else{
                $year = 20..date('y');
                $no = '/0001';
                $pvno = $year.$no;
                
                $newVoucher = Voucher::create([
                    'pvno'=>$pvno,
                    'totalamount'=> $payments->totalAmount,
                ]);

            }

            foreach ($payments->payments as $payment) {
                $tax_id = (int)$payment['data']['tax'];
                $beneficiary_id = (int)$payment['data']['beneficiary'];

                $paymentArray = [
                   'amount'=> $payment['data']['amount'],
                   'description'=> $payment['data']['description'],
                   'voucher_id'=> $newVoucher->id,
                   'beneficiary_id'=> $beneficiary_id,
                   'duedate'=> date('d/m/y'),
                   'tax_id'=> $tax_id,
                ];

                $newPayment = Payment::create($paymentArray);
                // $newPayment = DB::table('payments')->insert($paymentArray);

            }
            
            Cache::forget('payments');

            return redirect()->route('show_single_voucher', ['id'=>$newVoucher->id])->with(['message'=>'Voucher is added Successfully']);
            

        }else{
            return redirect('/create_voucher')->with(['errors'=>'No Payment in voucher']);
        }
    }


    public function delete_voucher_db($id)
    {
        $voucher = Voucher::find($id);
        
        $payments = DB::table('payments')->where('voucher_id', '=', $voucher->id)->get();

        if ($payments->count() > 0) {
            foreach($payments as $payment){
                DB::table('payments')->delete($payment->id);
            }
        }

        DB::table('vouchers')->delete($id);

        return redirect('/vouchers')->with(['errors'=>'Voucher is deleted']);
        
    }

    public function show_single_voucher($id)
    {
        $voucher = Voucher::find($id);
        $payments = DB::table('payments')->where('voucher_id', '=', $id)->get();

        return view('main.voucher.single_voucher')->with(['payments'=>$payments, "voucher"=>$voucher]);

    }
}
