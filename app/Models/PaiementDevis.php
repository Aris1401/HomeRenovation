<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class PaiementDevis extends Model
{
    use Sortable;

    protected $table = 'paiement_devis';
    public $timestamps = false;

    protected $primaryKey = 'pd_id';
    protected $fillable = [
        'pd_id_realisation_travaux',
        'pd_date_de_paiement',
        'pd_montant',
        'pd_ref_paiement'
    ];

    public $sortable = [
        'pd_id_realisation_travaux',
        'pd_date_de_paiement',
        'pd_montant',
        'pd_ref_paiement'
    ];

    public function realisationTravaux() : BelongsTo {
        return $this->belongsTo(RealisationTravaux::class, 'pd_id_realisation_travaux', 'rt_id');
    }
}
