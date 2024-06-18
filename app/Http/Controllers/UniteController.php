<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use Illuminate\Http\Request;

class UniteController extends Controller
{
    public function index() {
        $unites = Unite::paginate(10);

        return view("crud.unites.index", ["unites" => $unites]);
    }

    public function create() {
        return view("crud.unites.create");
    }

    public function store(Request $request) {
        $unite = Unite::create([
            "ut_designation" => $request->input("designation")
        ]);

        return redirect()->route("unites.index")->with("success","Unite inserer.");
    }

    public function edit($id) {
        $unite = Unite::find($id);

        return view("crud.unites.edit", ["unite"=> $unite]);
    }

    public function update(Request $request, $id) {
        $unite = Unite::find($id);
        $unite->update([
            "ut_designation"=> $request->input("designation")
        ]);

        return redirect()->route("unites.index")->with("success","Unite mis ajour");
    }

    public function destroy($id) {
        $unite = Unite::find($id);
        $unite->delete();

        return redirect()->route("unites.index")->with("success","Unite supprimer");
    }
}
