<?php

namespace App\Http\Controllers;

use App\Models\PaiementDevis;
use App\Models\RealisationTravaux;
use App\Models\TypeDeFinition;
use App\Models\TypeDeMaison;
use App\Models\TypeDeTravaux;
use App\Models\View\AvancementPaiement;
use App\Services\PaiementDevisService;
use App\Services\RealisationTravauxService;
use App\Services\UpdateMontantDevisService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealisationTravauxController extends Controller
{
    public function __construct(
        protected RealisationTravauxService $realisation_travaux_services,
        protected PaiementDevisService $paiement_devis_service,
        protected RealisationTravauxService $realisations_travaux_service,
        protected UpdateMontantDevisService $update_montant_devis_service
    )
    {
        
    }

    public function index() {
        $this->update_montant_devis_service->udpateMontantDevis();

        $utilisateur = Auth::user();

        // Obtenir les realisations de travaux des utilisateurs
        $realisations_travaux = RealisationTravaux::where('rt_id_utilisateur', $utilisateur->u_id)->get();

        return view('realisation.liste')->with('realisations', $realisations_travaux);
    }

    public function create() {
        $this->update_montant_devis_service->udpateMontantDevis();

        $type_de_maisons = TypeDeMaison::all();
        $type_de_finitions = TypeDeFinition::all();

        return view('realisation.realiser')->with('type_de_maisons', $type_de_maisons)
                                            ->with('type_de_finitions', $type_de_finitions);
    }

    public function store(Request $request) {
        $request->validate([
            'type-maison' => ['required'],
            'type-finition' => ['required'],
            'date-debut' => ['required'],
            'lieu' => ['required']
        ]);

        try {
            $this->realisation_travaux_services->insererReaisation(
                $request->input('type-maison'),
                $request->input('type-finition'),
                Carbon::parse($request->input('date-debut')),
                $request->input('lieu')
            );
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->to(route('realisaiton'));
    }

    public function paiement($id) {
        $avancement_paiement = AvancementPaiement::where('rt_id', $id)->first();

        return view('realisation.paiement', ['realisation_id' => $id])->with('avancement_paiement', $avancement_paiement);
    }

    public function effectuerPaiement(Request $request, $id) {
        $request->validate([
            'date-paiement' => ['required'],
            'montant-a-payer' => ['required'],
        ]);

        $montant_a_payer = $request->input('montant-a-payer');

        try {
            $this->paiement_devis_service->payerRealisation($id, $request->input('date-paiement'), $montant_a_payer);
        } catch (Exception $e) {
            return back()->withErrors(['errors' => $e->getMessage()]);
        } 

        return redirect()->to(route('realisaiton'));
    }

    public function validerPaiement(Request $request, $id) {
        $request->validate([
            'date-paiement' => ['required'],
            'montant-a-payer' => ['required'],
        ]);

        $errors = [];
        $message = '';

        $montant_a_payer = $request->input('montant-a-payer');
        
        try {
            $this->paiement_devis_service->payerRealisation($id, $request->input('date-paiement'), $montant_a_payer);
            $message = 'Paiement du montant de ' . $montant_a_payer . ' Ar effectuer';
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        } 

        return response()->json([
            'erreur' => $errors,
            'message' => $message,
            'data' => [],
            'date' => Carbon::now()
        ]);
    }

    public function export($id_realisation) {
        $realisation = RealisationTravaux::where('rt_id', $id_realisation)->first();

        $details_travaux = $this->realisations_travaux_service->obtenirDetailsTravaux($id_realisation);
        $type_travaux = TypeDeTravaux::all();

        $paiements = PaiementDevis::where('pd_id_realisation_travaux', $id_realisation)->get();

        return Pdf::loadView('realisation.pdf.details', ['details_travaux' => $details_travaux, 'type_travaux' => $type_travaux, 'paiements' => $paiements, 'realisation_travaux' => $realisation ])->download("Devis-N" . str_pad($realisation->rt_id, 4, 0, STR_PAD_LEFT));
    }
}
