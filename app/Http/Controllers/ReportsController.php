<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Budget;
use App\Payment;

class ReportsController extends Controller
{
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
        $budgets = Budget::all();

        // dd($beneficiaries);

        return view('main.reports.index')->with(['budgets' => $budgets, "single_report"=>0, "all_reports"=>0]);
    }

    public function generate_reports(Request $request)
    {
        $budgets = Budget::all();
        
        $b = $request->budget;
        $d = $request->daterange;

        if ($b == "all") {
            if ($d != 0) {
                $daterange = \explode(' - ', $d);

                $from = $daterange[0];
                $from = \explode('/', $from);
                $from = $from[2].'-'.$from[0].'-'.$from[1];

                $to = $daterange[1];
                $to = \explode('/', $to);
                $to = $to[2].'-'.$to[0].'-'.$to[1];
                
                $buds = Budget::whereBetween('created_at', [$from." 00:00:00",$to." 23:59:59"])->get();

                $arr = [];
                foreach ($buds as $bud) {
                    $paymentss = Payment::where('budget_id', '=', $bud->id)->get();

                    $p_amount_rr = [];
                    foreach ($paymentss as $p) {
                        array_push($p_amount_rr, $p->amount);
                    }
                    
                    $pp_amount = 0;
                    for ($i=0; $i < count($p_amount_rr); $i++) { 
                        $pp_amount = $pp_amount + $p_amount_rr[$i];
                    }
                    
                    $budget_amount_r = $bud->amount;
                    $trail_balance_r = $bud->amount - $pp_amount;

                    $single_report_r = [$bud->description, $budget_amount_r, $pp_amount, $trail_balance_r];

                    array_push($arr, $single_report_r);
                }

                $budget_reports = $arr;
        
                // dd($budget_reports);
                return view('main.reports.all')->with(['budgets' => $budgets, 'budget_reports' => $budget_reports]);
            }
            return view('main.reports.check')->with(['budgets' => $budgets, "all"=>1]);
        }else {
            $budget = Budget::find($b);
            $payments = Payment::where('budget_id', '=', $budget->id)->get();

            $p_amount_r = [];
            foreach ($payments as $p) {
                array_push($p_amount_r, $p->amount);
            }
            $p_amount = 0;
            for ($i=0; $i < count($p_amount_r); $i++) { 
                $p_amount = $p_amount + $p_amount_r[$i];
            }

            $budget_amount = $budget->amount;
            $trail_balance = $budget->amount-$p_amount;
            
            $single_report = [$budget->description, $budget_amount, $p_amount, $trail_balance];

            return view('main.reports.single')->with(['budgets' => $budgets, 'single_report'=>$single_report]);
        }


        // dd($budget);
        // return $budget;
    }

}
