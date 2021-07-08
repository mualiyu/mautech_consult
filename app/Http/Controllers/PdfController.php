<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Barryvdh\DomPDF\PDF;
use App\Mandate;
use Barryvdh\DomPDF\Facade as PDF;
use NumberToWords\NumberToWords;
use App\Budget;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Create_pdf_voucher($id)
    {
        $voucher = DB::table('vouchers')->where('id', '=', $id)->get();
        // dd($voucher[0]->pvno);

        $payments = DB::table('payments')->where('voucher_id', '=', $voucher[0]->id)->get();
        $pay = Payment::where('voucher_id', '=', $voucher[0]->id)->first();
        $budget = Budget::find($pay->budget_id);
        $mandate = Mandate::where('voucher_id', '=', $voucher[0]->id)->first();

        //convertion to word
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        $amountInWords = $numberTransformer->toWords((int)$voucher[0]->totalamount);

        // $amountInWords = $this->numberTowords((int)$voucher[0]->totalamount);
        // dd($amountInWords);

        // return view('pdf.voucher')->with(['voucher' => $voucher, 'payments' => $payments, 'amountInWords' => $amountInWords]);

        $pdf = PDF::loadView('pdf.voucher', compact('voucher', 'payments', 'amountInWords', 'budget', 'mandate'))->setPaper('a4');

        return $pdf->stream('voucher_' . $voucher[0]->pvno . '.pdf');
    }

    public function mandate()
    {
        $pdf = PDF::loadView('pdf.mandate')->setPaper('a4', 'landscape');

        return  $pdf->stream('mandate.pdf');
        // view('pdf.mandate');
    }

    public function create_pdf_mandate($id)
    {
        $man_no = \explode('-', $id);
        $mandateno = 'FGN/OPP/' . $man_no[0] . '/' . $man_no[1];

        $mandates = DB::table('mandates')->where('mandateno', '=', $mandateno)->get();

        $pdf = PDF::loadView('pdf.mandate', compact('mandates', 'mandateno'))->setPaper('a4', 'landscape');

        return $pdf->stream('mandate' . $id . '.pdf');
    }

    public function create_pdf_cashbook()
    {
        $payments = Payment::all();

        $arr = [];
        foreach ($payments as $payment) {
            $budgets = Budget::find($payment->budget_id);
            $account = $budgets->account_code;

            array_push($arr, $account);
        }
        $accounts = array_unique($arr);


        $pdf = PDF::loadView('pdf.cash', compact('payments', 'accounts'))->setPaper('a4', 'landscape');

        // return view('pdf.cash', compact('payments'))->with(['accounts' => $accounts]);

        return $pdf->stream('cashbook.pdf');
    }

    public function create_pdf_cashbook_range(Request $request)
    {
        $daterange = $request->daterange;
        $daterange = \explode(' - ', $daterange);

        $from = $daterange[0];
        $from = \explode('/', $from);
        $from = $from[2] . '-' . $from[0] . '-' . $from[1];

        $to = $daterange[1];
        $to = \explode('/', $to);
        $to = $to[2] . '-' . $to[0] . '-' . $to[1];

        $payments = Payment::whereBetween('created_at', [$from . " 00:00:00", $to . " 23:59:59"])->get();

        $arr = [];
        foreach ($payments as $payment) {
            $budgets = Budget::find($payment->budget_id);
            $account = $budgets->account_code;

            array_push($arr, $account);
        }
        $accounts = array_unique($arr);

        $pdf = PDF::loadView('pdf.cash', compact('payments', 'accounts'))->setPaper('a4', 'landscape');

        // return view('pdf.cash', compact('payments'))->with(['accounts'=>$accounts]);

        if ($payments->count() > 0) {
            return $pdf->stream('cashbook.pdf');
        } else {
            return redirect('payments')->with(['errors' => "Date not found!"]);
        }
    }
}
