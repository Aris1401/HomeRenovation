<?php

namespace App\Services;

use App\Models\PaiementDevis;
use App\Models\RealisationTravaux;
use Carbon\Carbon;
use Exception;

class PaiementDevisService
{
    public function payerRealisation($id_realisation, $date_paiement, $montant) {
        // Verifier que le montant que l'user veut payer n'est pas trop grand
        $realisation_travaux = RealisationTravaux::where('rt_id', $id_realisation)->first();
        $montant_a_payer = $montant;

        $montant_total = $realisation_travaux->avancementPaiement->montant_a_payer;
        $deja_payer = $realisation_travaux->avancementPaiement->total_deja_payer;

        $montant_en_ajout = $montant_a_payer + $deja_payer;
        $montant_a_retirer = $montant_en_ajout - $montant_total;

        if ($montant_en_ajout > $montant_total) {
            throw new Exception('Montant bien trop grand ajouter au paiement precedent. Veuillez retirer: ' . ($montant_a_retirer) . " Ar");
        }

        $paiement_devis_data = [
            'pd_id_realisation_travaux' => $id_realisation,
            'pd_date_de_paiement' => Carbon::parse($date_paiement),
            'pd_montant' => $montant
        ];

        return PaiementDevis::create($paiement_devis_data);
    }
}
