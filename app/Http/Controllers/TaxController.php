<?php

namespace App\Http\Controllers;

use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = Tax::all();

        return view("main.tax.index")->with(['taxes' => $taxes]);
    }

    public function show_add_tax()
    {
        return view("main.tax.add_tax");
    }

    public function show_edit_tax($id)
    {
        $tax = Tax::find($id);

        return view("main.tax.edit_tax")->with(['tax'=> $tax]);
    }

    public function create_tax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "type" => "string",
            "percentage" => "string",
        ]);

        if ($validator->fails()) {
            return redirect()->route("show_add_tax")
                ->withErrors($validator)
                ->withInput();
        }

        $arrayToInsert = [
            "type" => $request->input("type"),
            "percentage" => $request->input("percentage"),
        ];

        Tax::create($arrayToInsert);
        // DB::table('taxes')->insert($arrayToInsert);

        return redirect('/taxes')->with(['message' => "New Tax is added"]);
    }

    public function update_tax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "type" => "string",
            "percentage" => "string",
        ]);

        if ($validator->fails()) {
            return redirect()->route("show_edit_tax", ['id'=>$id])->with(['error'=> "server Can not Validate Entries"]);
        }

        $arrayToUpdate = [
            "type" => $request->input("type"),
            "percentage" => $request->input("percentage"),
        ];

        Tax::where('id', '=', $id)->update($arrayToUpdate);
        // DB::table('taxes')->where('id', '=', $id)->update($arrayToUpdate);

        return redirect('/taxes')->with(['message' => "Tax is Updated"]);
    }

    public function delete_tax($id)
    {
        $del_tax = TAx::destroy($id);

        if(!$del_tax){
            return redirect('/taxes')->with(["error"=>"System Can't delete Tax Now! Try Later."]);
        }

        return redirect('/taxes')->with(['message' =>"Tax is deleted."]);
    }
}
