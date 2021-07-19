<?php

namespace App\Http\Controllers;

use App\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
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

        return view('main.budgets.index')->with(['budgets' => $budgets]);
    }

    public function show_add_bud()
    {
        return view("main.budgets.add");
    }


    public function create_bud(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "account_code" => "string",
            "description" => "string",
            "amount" => "string",
        ]);

        if ($validator->fails()) {
            return redirect()->route("show_add_budget")
                ->withErrors($validator)
                ->withInput();
        }

        $arrayToInsert = [

            "account_code" => $request->input("account_code"),
            "description" => $request->input("description"),
            "amount" => $request->input("amount") * 100,
        ];

        Budget::create($arrayToInsert);
        // DB::table('beneficiaries')->insert($arrayToInsert);

        return redirect()->route("budgets")->with(['message' => "New budget is added"]);
    }

    public function show_edit_bud($id)
    {
        $budget = Budget::find($id);

        return view("main.budgets.edit")->with(['budget' => $budget]);
    }


    public function update_bud(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "account_code" => "string",
            "description" => "string",
            "amount" => "string",
        ]);

        if ($validator->fails()) {
            return redirect()->route("show_edit_budget", ['id' => $id])
                ->with(['error' => "Update Fails Try Again"]);
        }

        $arrayToUpdate = [

            "account_code" => $request->input("account_code"),
            "description" => $request->input("description"),
            "amount" => $request->input("amount") * 100,
        ];

        DB::table('budgets')->where('id', '=', $id)->update($arrayToUpdate);

        return redirect()->route("show_edit_budget", ['id' => $id])->with(['message' => "Budget is Updated"]);
    }

    public function delete_bud($id)
    {
        $del_bud = Budget::destroy($id);

        if (!$del_bud) {
            return redirect()->route('budgets')->with(["error" => "System Can't delete Budget Now! Try Later."]);
        }

        return redirect()->route('budgets')->with(['message' => "Budget is deleted."]);
    }
}
