<?php

namespace App\Models\View;

use App\Models\RealisationTravaux;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvancementPaiement extends Model
{
    protected $table = 'v_avancement_paiement_complet';
    public $timestamps = false;

    public function realisationTravaux() : BelongsTo {
        return $this->belongsTo(RealisationTravaux::class, 'rt_id', 'rt_id');
    }
}
