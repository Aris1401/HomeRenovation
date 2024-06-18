<?php

namespace App\Http\Controllers;

use App\Models\Import\ImportRealisation;
use App\Models\RealisationTravaux;
use App\Services\ImportService;
use Exception;
use Illuminate\Http\Request;

class InsertionDonneesController extends Controller
{
    public function __construct(
        protected ImportService $import_service
    )
    {
        
    }

    public function showMaisonTravauxDevis() {
        return view('import.maison-travaux-devis');
    }

    public function importerMaisonTravauxDevis(Request $request) {
        $maison_travaux = $request->file('maison-travaux');
        $devis_client = $request->file('devis');

        $erreurs = [];
        $nombre_ligne_1 = 0;
        $nombre_ligne_2 = 0;
        
        try {
            $nombre_ligne_1 = $this->import_service->importerMaisonTravaux($maison_travaux, $erreurs);
        } catch (Exception $e) {
            return back()->withErrors(['errors' => $erreurs]);
        }

        try {
            $nombre_ligne_2 = $this->import_service->importerDevisClient($devis_client, $erreurs);
        } catch (Exception $e) {
            return back()->withErrors(['errors' => $erreurs]);
        }


        return view('import.success', ['nombres_lignes' => $nombre_ligne_1 . ' et ' . $nombre_ligne_2, 'last_route' => 'import.maison-travaux']);
    }

    public function showPaiement() {
        return view('import.paiement');
    }

    public function importerPaiement(Request $request) {
        $paiement = $request->file('paiements');

        $erreurs = [];
        $nombre_ligne_1 = 0;

        try {
            $nombre_ligne_1 = $this->import_service->importerPaiements($paiement, $erreurs);
        } catch (Exception $e) {
            return back()->withErrors(['errors' => $erreurs]);
        }

        return view('import.success', ['nombres_lignes' => $nombre_ligne_1, 'last_route' => 'import.paiement']);
    }
}
