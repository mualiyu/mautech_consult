<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Income;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IncomesImport;

class IncomeController extends Controller
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
        $incomes = Income::all();

        return view('main.incomes.index', compact("incomes"));
    }

    public function show_add_income()
    {
        return view('main.incomes.add');
    }

    public function create_income(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "payer" => "string",
            "ref_num" => "",
            "amount" => "",
            "type" => "string",


        ]);

        if ($validator->fails()) {
            return redirect()->route("show_add_income")
                ->withErrors($validator)
                ->withInput();
        }

        $arrayToInsert = [
            "payer" => $request->input("payer"),
            "ref_num" => $request->input("ref_num"),
            "amount" => $request->input('amount') * 100,
            "type" => $request->input('type'),
        ];

        Income::create($arrayToInsert);
        // DB::table('taxes')->insert($arrayToInsert);

        return redirect('/incomes')->with(['errors' => "New Income is added"]);
    }

    public function importIncome(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "file" => "required",

        ]);
        if ($validator->fails()) {
            return redirect()->route("")
                ->withErrors($validator)
                ->withInput();
        }

        Excel::import(new IncomesImport, $request->file('file'));

        return redirect('/incomes')->with(['errors' => "Income uploaded Successful"]);
    }

    public function download_sample()
    {
        $filePath = public_path("sam/sample_income.csv");
        // dd($filePath);
        $headers = ['Content-Type: text/csv'];
        $fileName = 'sample_' . time() . '.csv';

        return response()->download($filePath, $fileName, $headers);
    }
}
