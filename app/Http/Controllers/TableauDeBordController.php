<?php

namespace App\Http\Controllers;

use App\Charts\HistogrammeMontantDevisGraph;
use App\Models\View\MontantDevisMois;
use App\Models\View\MontantTotalPaiements;
use App\Models\View\MontantTotalRealisation;
use App\Services\UtilsService;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableauDeBordController extends Controller
{
    public function index(Request $request) {
        $montant_total_devises = MontantTotalRealisation::first();
        $montant_total_paiements = MontantTotalPaiements::first();

        // Les annees disponibles
        $annees = DB::table('v_annees_disponible')->get();

        // Histogramme
        $histogramme_motant_graph = new HistogrammeMontantDevisGraph();
        $chart_labels = [];
        $chart_dataset = [];
        $chart_colors = [];

        if ($request->input('annee')) {
            $montant_devis_mois = MontantDevisMois::where('annee', $request->input('annee'))->get();
            foreach($montant_devis_mois as $montant) {
                $chart_labels[] = $montant->mois;
                $chart_dataset[] = $montant->montant;
    
                $hex_color =  sprintf("#%02x%02x%02x", mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
                $chart_colors[] = $hex_color;
            }
    
        }
        
        # Ajouter les options pour le graph
        # Obtenir le maximun montant des devis
        $max_montant_devis = UtilsService::roundUpToNearestFive(MontantDevisMois::max('montant'));
        FacadesDebugbar::addMessage("Max montant is: " . $max_montant_devis);

        $histogramme_motant_graph->options([
            'scales' => [
                'y' => [
                    'max' => $max_montant_devis,
                ]
            ]
        ]);
        $histogramme_motant_graph->labels($chart_labels);
        $histogramme_motant_graph->dataset('Montant des devis', 'bar', $chart_dataset)->options(['backgroundColor' => $chart_colors]);
        return view('tableau-de-bord')->with('total_devis', $montant_total_devises)->with('total_paiements', $montant_total_paiements)->with('histogramme_montant', $histogramme_motant_graph)->with('annees', $annees);
    }
}
