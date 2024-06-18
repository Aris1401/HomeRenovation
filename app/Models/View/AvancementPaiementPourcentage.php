<?php

namespace App\Models\View;

use App\Models\RealisationTravaux;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvancementPaiementPourcentage extends Model
{
    protected $table = 'v_avancement_paiement_complet_pourcentage';
    public $timestamps = false;

    public function realisationTravaux() : BelongsTo {
        return $this->belongsTo(RealisationTravaux::class, 'rt_id', 'rt_id');
    }
}
