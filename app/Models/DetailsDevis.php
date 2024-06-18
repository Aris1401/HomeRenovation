<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class DetailsDevis extends Model
{
    use Sortable;

    protected $table = 'details_devis';
    public $timestamps = false;

    protected $primaryKey = 'dd_id';
    protected $fillable = [

        'dd_id_devis',
        'dd_id_type_travaux',
        'dd_designation',
        'dd_code_details',
        'dd_id_unite',
        'dd_quantite',
        'dd_prix_unitaire',
        'dd_montant_total',
        'dd_parent',
        'dd_description'
    ];

    public $sortable = [

        'dd_id_devis',
        'dd_id_type_travaux',
        'dd_designation',
        'dd_code_details',
        'dd_id_unite',
        'dd_quantite',
        'dd_prix_unitaire',
        'dd_montant_total',
        'dd_parent',
        'dd_description'
    ];

    public function unite() : BelongsTo {
        return $this->belongsTo(Unite::class, 'dd_id_unite', 'ut_id');
    }

    public function devis() : BelongsTo {
        return $this->belongsTo(Devis::class, 'dd_id_devis', 'd_id');
    }
    
    public function typeDeTravaux() : BelongsTo {
        return $this->belongsTo(TypeDeTravaux::class, 'dd_id_type_travaux', 'tt_id');
    }
}
