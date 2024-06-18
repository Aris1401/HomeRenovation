<?php

namespace App\Http\Controllers;

use App\Models\DetailsDevis;
use App\Models\Devis;
use App\Models\TypeDeTravaux;
use App\Models\Unite;
use Illuminate\Http\Request;

class DetailsDevisController extends Controller
{
    public function index($id) {
        $devis = Devis::where('d_id', $id)->first();
        $type_de_travaux = TypeDeTravaux::all();
        $unites = Unite::all();

        return view('devis.travaux.ajout')->with('devis', $devis)->with('type_de_travaux', $type_de_travaux)->with('unites', $unites);
    }

    public function liste() {
        $details_devis = DetailsDevis::paginate(10);

        return view("crud.details-devis.index", ["details_devises" => $details_devis]);
    }

    public function edit($id) {
        $details_devis = DetailsDevis::find($id);
        $unite = Unite::all();

        return view("crud.details-devis.edit", ["details_devis"=> $details_devis, 'unites' => $unite]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            "dd_designation"=> ['required'],
            "dd_code_details"=> ['required'],
            "dd_id_unite"=> ['required'],
            "dd_quantite"=> ['required', 'gt:0'],
            "dd_prix_unitaire"=> ['required', 'gt:0'],
        ]);

        $details_devis = DetailsDevis::find($id);

        $prix_unitaire = $request->input("dd_prix_unitaire");
        $quantite = $request->input("dd_quantite");

        $montant_total = $prix_unitaire * $quantite;

        $details_devis->update([
            "dd_id_type_travaux"=> $request->input("dd_id_type_travaux"),
            "dd_designation"=> $request->input("dd_designation"),
            "dd_code_details"=> $request->input("dd_code_details"),
            "dd_id_unite"=> $request->input("dd_id_unite"),
            "dd_quantite"=> $quantite,
            "dd_prix_unitaire"=> $prix_unitaire,
            "dd_montant_total"=> $montant_total,
            "dd_parent"=> $request->input("dd_parent"),
            "dd_description"=> $request->input("dd_description")
        ]);

        return redirect()->route("details-devis.index")->with("success","DetailsDevis mis ajour");
    }
}
