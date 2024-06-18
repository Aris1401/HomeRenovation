<?php

namespace App\Services;

use App\Models\DetailsDevis;
use App\Models\DetailsRealisation;
use App\Models\Devis;
use App\Models\PaiementDevis;
use App\Models\RealisationTravaux;
use App\Models\TypeDeFinition;
use App\Models\TypeDeMaison;
use App\Models\Unite;
use Exception;
use Illuminate\Support\Facades\DB;

class ResetBaseService
{
    public function reinitisaliserDonnees() {
        Unite::truncate();    
        
        PaiementDevis::truncate();

        DetailsRealisation::truncate();

        RealisationTravaux::truncate();

        DetailsDevis::truncate();

        Devis::truncate();
        
        TypeDeMaison::truncate();
        
        TypeDeFinition::truncate();

        DB::delete('delete from utilisateur where u_id_profil_utilisateur = ?', [2]);
    }
}
