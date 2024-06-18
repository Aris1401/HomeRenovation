<?php

namespace App\Http\Controllers;

use App\Models\RealisationTravaux;
use App\Models\TypeDeTravaux;
use App\Models\View\AvancementPaiement;
use App\Services\RealisationTravauxService;
use Illuminate\Http\Request;

class RealisationTravauxAdminController extends Controller
{
    public function __construct(
        protected RealisationTravauxService $realisations_travaux_service
    )
    {
        
    }

    public function index() {
        // Obtenir les realisations de travaux des utilisateurs
        $realisations_travaux = RealisationTravaux::paginate(3);

        return view('realisation.admin.liste')->with('realisations', $realisations_travaux);
    }

    public function details($id_realisation) {
        $realisation = RealisationTravaux::where('rt_id', $id_realisation)->first();

        $details_travaux = $this->realisations_travaux_service->obtenirDetailsTravaux($id_realisation);
        $type_travaux = TypeDeTravaux::all();

        $avancement_paiement = AvancementPaiement::where('rt_id', $id_realisation)->first();

        return view('realisation.admin.details')->with('realisation', $realisation)->with('details_travaux', $details_travaux)->with('type_travaux', $type_travaux)->with('avancement_paiement', $avancement_paiement);
    }
}
