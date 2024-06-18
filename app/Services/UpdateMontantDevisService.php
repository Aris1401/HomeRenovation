<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class UpdateMontantDevisService
{
    public function udpateMontantDevis()
    {
        // DB::update('
        //     update 
        //         devis
        //     set d_montant_total = view.montant
        //         from v_total_devis_complet as view
        //     where 
        //     view.d_id = devis.d_id
        // ');
    }
}
