<?php

namespace App\Services;

use App\Models\DetailsDevis;
use App\Models\DetailsRealisation;
use App\Models\RealisationTravaux;
use App\Models\TypeDeFinition;
use App\Models\TypeDeMaison;
use App\Models\TypeDeTravaux;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class RealisationTravauxService
{
    public function insererReaisation($id_type_de_maison, $id_type_de_finition, Carbon $date_debut, $lieu) {
        $type_maison = TypeDeMaison::where('tm_id', $id_type_de_maison)->first();
        $type_finition = TypeDeFinition::where('tf_id', $id_type_de_finition)->first();

        // Obtenir le devis correspondant
        $devis = null;
        if (!$type_maison->devis->first()) throw new Exception('Aucun devis correnspondant au type de maison: ' . $type_maison->tm_designation);
        else {
            $devis = $type_maison->devis->first();
        }

        // Creation de realistion travaux
        $user = Auth::user();

        $montant_total = (float) $devis->d_montant_total * (1.0 + ((float) $type_finition->tf_augmentation_prix / 100.0));

        // Calcul de date fin
        $date_fin = $date_debut->copy();
        $date_fin = $date_fin->addDays((float) $type_maison->tm_duree_travaux);

        $realisation_travaux_data = [
            'rt_id_utilisateur' => $user->u_id,
            'rt_id_devis' => $devis->d_id,
            'rt_id_type_de_maison' => $id_type_de_maison,
            'rt_id_type_de_finition' => $id_type_de_finition,
            'rt_date_debut_travaux' => $date_debut,
            'rt_date_fin_travaux' => $date_fin,
            'rt_montant_total' => $montant_total,
            'rt_augmentation' => $type_finition->tf_augmentation_prix,
            'rt_duree_travail' => $type_maison->tm_duree_travaux,
            'rt_lieu' => $lieu
        ];

        $realisation_travaux = RealisationTravaux::create($realisation_travaux_data);

        // Historisation des travaux
        $details_devis = DetailsDevis::where('dd_id_devis', $devis->d_id)->get();
        foreach($details_devis as $detail_devis) {
            $details_realisation_data = [
                'dr_id_realisation_travaux' => $realisation_travaux->rt_id,
                'dr_id_type_travaux' => $detail_devis->dd_id_type_travaux,
                'dr_designation' => $detail_devis->dd_designation,
                'dr_code_details' => $detail_devis->dd_code_details,
                'dr_id_unite' => $detail_devis->dd_id_unite,
                'dr_quantite' => $detail_devis->dd_quantite,
                'dr_prix_unitaire' => $detail_devis->dd_prix_unitaire,
                'dr_montant_total' => $detail_devis->dd_montant_total,
                'dr_parent' => $detail_devis->dd_parent,
                'dr_description' => $detail_devis->dd_description
            ];

            DetailsRealisation::create($details_realisation_data);
        }

        return $realisation_travaux;
    } 

    public function obtenirDetailsTravaux($id_realisation) {
        // Obtenir realisation
        $realisation = RealisationTravaux::where('rt_id', $id_realisation)->first();

        $details_travaux = [];

        // Obtenir les details de realisation
        $details_realisations = DetailsRealisation::where('dr_id_realisation_travaux', $id_realisation)->get();
        $types_de_travail = TypeDeTravaux::all();

        // foreach($types_de_travail as $type_de_travail) {
        //     $temp = [];
        //     foreach($details_realisations as $details_realisation) {
        //         if ((int) $type_de_travail->tt_id == (int) $details_realisation->dr_id_type_travaux) {
        //             $temp[] = $details_realisation;
        //         }
        //     }
        //     $details_travaux[$type_de_travail->tt_designation] = $temp; 
        // }

        $details_travaux = $details_realisations;

        return $details_travaux;
    }
}
