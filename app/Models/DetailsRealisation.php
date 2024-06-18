<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class DetailsRealisation extends Model
{
    use Sortable;

    protected $table = 'details_realisation';
    public $timestamps = false;

    protected $primaryKey = 'dr_id';
    protected $fillable = [
        'dr_id_realisation_travaux',
        'dr_id_type_travaux',
        'dr_designation',
        'dr_code_details',
        'dr_id_unite',
        'dr_quantite',
        'dr_prix_unitaire',
        'dr_montant_total',
        'dr_parent',
        'dr_description'
    ];

    public $sortable = [
        'dr_id_realisation_travaux',
        'dr_id_type_travaux',
        'dr_designation',
        'dr_code_details',
        'dr_id_unite',
        'dr_quantite',
        'dr_prix_unitaire',
        'dr_montant_total',
        'dr_parent',
        'dr_description'
    ];

    public function realisationTravaux() : BelongsTo {
        return $this->belongsTo(RealisationTravaux::class, 'dr_id_realisation_travaux', 'rt_id');
    }
    public function typeDeTravaux() : BelongsTo {
        return $this->belongsTo(TypeDeTravaux::class, 'dr_id_type_travaux', 'tt_id');
    }
    public function unite() : BelongsTo {
        return $this->belongsTo(Unite::class, 'dr_id_unite', 'ut_id');
    }
}
