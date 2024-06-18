<?php

namespace App\Http\Controllers;

use App\Models\TypeDeFinition;
use Illuminate\Http\Request;

class TypeDeFinitionController extends Controller
{
    public function index() {
        $type_de_finitions = TypeDeFinition::paginate(10);

        return view("crud.type-de-finitions.index", ["type_de_finitions" => $type_de_finitions]);
    }

    public function create() {
        return view("crud.type-de-finitions.create");
    }

    public function store(Request $request) {
        $type_de_finition = TypeDeFinition::create([

            "tf_designation" => $request->input("tf_designation"),
            "tf_augmentation_prix" => $request->input("tf_augmentation_prix")
        ]);

        return redirect()->route("type-de-finition.index")->with("success","TypeDeFinition inserer.");
    }

    public function edit($id) {
        $type_de_finition = TypeDeFinition::find($id);

        return view("crud.type-de-finitions.edit", ["type_de_finition"=> $type_de_finition]);
    }

    public function update(Request $request, $id) {
        $type_de_finition = TypeDeFinition::find($id);
        $type_de_finition->update([

            "tf_designation"=> $request->input("tf_designation"),
            "tf_augmentation_prix"=> $request->input("tf_augmentation_prix")
        ]);

        return redirect()->route("type-de-finition.index")->with("success","TypeDeFinition mis ajour");
    }

    public function destroy($id) {
        $type_de_finition = TypeDeFinition::find($id);
        $type_de_finition->delete();

        return redirect()->route("type-de-finition.index")->with("success","TypeDeFinition supprimer");
    }
}
