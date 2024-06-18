<?php

namespace App\Http\Controllers;

use App\Models\DetailsDevis;
use App\Models\Devis;
use App\Models\TypeDeMaison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Seuelemt admin
class DevisController extends Controller
{
    public function index() {
        // Obtenir la liste de tout les devis 
        $devises = Devis::all();

        return view('devis.liste')->with('devises', $devises);
    }

    public function create() {
        // Obtenir les types de maisons
        $type_de_maisons = TypeDeMaison::all();

        return view('devis.create')->with('type_de_maisons', $type_de_maisons);
    }

    public function store(Request $request) {
        $devis = Devis::create([
            "d_date_ajout" => $request->input("date-ajout"),
            "d_type_de_maison" => $request->input("type-maison"),
            "d_designation" => $request->input("designation")
        ]);

        return redirect()->route("devis.index")->with("success","Devis inserer.");
    }

    public function show($id) {
        $devis = Devis::where('d_id', $id)->first();

        // Obtenir les details des devis
        $details_devis = DetailsDevis::where('dd_id_devis', $id)->get();

        return view('devis.details')->with('devis', $devis)->with('travaux', $details_devis);
    }
}
