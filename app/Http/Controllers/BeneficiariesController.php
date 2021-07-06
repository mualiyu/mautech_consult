<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class BeneficiariesController extends Controller
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
        $beneficiaries = Beneficiary::all();

       // dd($beneficiaries);

        return view('main.beneficiaries')->with(['beneficiaries'=>$beneficiaries]);
    }

    public function show_add_ben()
    {
        return view("main.add_ben");
    }

    public function create_ben(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "string",
            "code" => "string",
            "account" => "string",
            "bank" => "string",
            "tin" => "string",
            "tag" => "string|nullable",
        ]);

        if ($validator->fails()) {
            return redirect()->route("show_add_beneficiary")
            ->withErrors($validator)
            ->withInput();
        }

        $arrayToInsert = [

            "name" => $request->input("name"),
            "code" => $request->input("code"),
            "account" => $request->input("account"),
            "bank" => $request->input("bank"),
            "tin" => $request->input("tin"),
            "tag" => $request->input("tag"),
        ];

        $ben = Beneficiary::create($arrayToInsert);
        DB::table('beneficiaries')->where('id', '=', $ben->id)->update(["tag"=>$request->tag]);
        // DB::table('beneficiaries')->insert($arrayToInsert);

        return redirect()->route("beneficiaries")->with(['message'=> "New beneficiary is added"]);

    }

    public function show_edit_ben($id)
    {
        $beneficiary = Beneficiary::find($id);

        return view("main.edit_ben")->with(['beneficiary'=> $beneficiary]);
    }

    public function update_ben(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "string",
            "code" => "string",
            "account" => "string",
            "bank" => "string",
            "tin" => "string",
            "tag" => "string|nullable",
        ]);

        if ($validator->fails()) {
            return redirect()->route("show_edit_beneficiary", ['id'=>$id])
            ->with(['error'=> "Update Fails Try Again"]);
        }

        $arrayToUpdate = [

            "name" => $request->input("name"),
            "code" => $request->input("code"),
            "account" => $request->input("account"),
            "bank" => $request->input("bank"),
            "tin" => $request->input("tin"),
            "tag" => $request->input("tag"),
        ];

        DB::table('beneficiaries')->where('id', '=', $id)->update($arrayToUpdate);

        return redirect()->route("show_edit_beneficiary", ['id'=>$id])->with(['message'=> "Beneficiary is Updated"]);
    }

    public function delete_ben($id)
    {
        $del_ben = Beneficiary::destroy($id);

        if(!$del_ben){
            return redirect()->route('beneficiaries')->with(["error"=>"System Can't delete Beneficiary Now! Try Later."]);
        }

        return redirect()->route('beneficiaries')->with(['message' =>"Beneficiary is deleted."]);

    }
}
