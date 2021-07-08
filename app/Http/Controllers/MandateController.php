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
use App\Mandate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class MandateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mandates = Mandate::all();

        $arr = [];
        foreach ($mandates as $mandate) {
            $no = $mandate->mandateno;
            // $ex = explode('/', $no);
            // $in = $ex[3];
            array_push($arr, $no);
        }
	$mandate_s = array_unique($arr);
	$mandate_ss = array_reverse($mandate_s);
	// dd($mandate_s);
        return view('main.mandate.index')->with(['mandates'=> $mandate_ss]);
        
    }


    public function show_create_mandate()
    {
        // Cache::forget('mandates');
        $mandates = Cache::get("mandates");

        $vouchers = Voucher::all();
        
        return view('main.mandate.voucher_cache')->
		with(['vouchers'=>$vouchers, 'mandates'=>$mandates]);
	
    }

    public function create_cache_mandate(Request $request)
    {

         Cache::put('mandates', $request->all(), 2592000);

        return redirect()->route('show_create_mandate');
    }

    public function delete_local_mandate()
    {
        Cache::forget('mandates');

            return redirect()->route('show_create_mandate')->with(['errors'=>'Mandate is deleted Successfully']);
    }

    public function store_mandate()
    {
        $mandates = Cache::get("mandates");

        if ($mandates) {
            $db_mandate = Mandate::count();

            if ($db_mandate != 0) {
                 $lastMandate = DB::table('mandates')->orderBy('id', 'DESC')->first();
                $ex = explode('/', $lastMandate->mandateno);
                $in = $ex[3]+'1';
                $in = sprintf("%'04d", $in);
                $mandateno = $ex[0].'/'.$ex[1].'/'.$ex[2].'/'.$in;
                
            }else {
            
                $year = 20..date('y');
                $no = '/0001';
                $mandateno = 'FGN/OPP/'.$year.$no;
                
            }
            
            foreach($mandates['voucher'] as $vid) 
             {
                $voucher = DB::table('vouchers')->where('id','=', (int)$vid)->get();
                
                $payments = DB::table('payments')->where('voucher_id','=', (int)$vid)->get();
                foreach ($payments as $payment) {
                    $beneficiary = DB::table('beneficiaries')->where('id','=', $payment->beneficiary_id)->get();
                    
                    $arrayToInsert =[
                        'mandateno'=> $mandateno,
                        'payment_id' => $payment->id,
                        'beneficiary_id'=> $beneficiary[0]->id,
                        'voucher_id'=> $voucher[0]->id,
                        
                    ];

                    DB::table('mandates')->insert($arrayToInsert);
                    // Mandate::create($arrayToInsert);
                    
                }
            }
	    Cache::forget('mandates');

	    $manNo = explode('/', $mandateno);
	    $manNo = $manNo[2].'-'.$manNo[3];
            return redirect()->route('show_single_mandate', ['id'=>$manNo]);

            //return $this->show_single_mandate($mandateno);
        }else {
            return redirect()->route('show_create_mandate')->with(["errors"=>"No mandate in Cache!"]);
        }
        
    }


    public function show_single_mandate($id)
    {
        $man_no = \explode('-', $id);
        $mandateno = 'FGN/OPP/'.$man_no[0].'/'.$man_no[1];
        // dd($mandateno);
        $mandates = DB::table('mandates')->where('mandateno', '=', $mandateno)->get();

        return view('main.mandate.single_mandate')->with(['mandateno'=>$mandateno, 'mandates'=>$mandates, 'i_d'=>$id]);
    }

}
