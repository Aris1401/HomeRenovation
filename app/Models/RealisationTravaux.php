<?php

namespace App\Models;

use App\Models\View\AvancementPaiementPourcentage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class RealisationTravaux extends Model
{
    use Sortable;

    protected $table = 'realisation_travaux';
    public $timestamps = false;

    protected $primaryKey = 'rt_id';
    protected $fillable = [
        'rt_id_utilisateur',
        'rt_id_devis',
        'rt_id_type_de_maison',
        'rt_id_type_de_finition',
        'rt_date_ajout_realisation',
        'rt_date_debut_travaux',
        'rt_date_fin_travaux',
        'rt_montant_total',
        'rt_augmentation',
        'rt_duree_travail',
        'rt_lieu',
        'rt_ref_devis'
    ];

    public $sortable = [
        'rt_id_utilisateur',
        'rt_id_devis',
        'rt_id_type_de_maison',
        'rt_id_type_de_finition',
        'rt_date_ajout_realisation',
        'rt_date_debut_travaux',
        'rt_date_fin_travaux',
        'rt_montant_total',
        'rt_augmentation',
        'rt_duree_travail',
        'rt_lieu',
        'rt_ref_devis'
    ];

    public function utilisateur() : BelongsTo {
        return $this->belongsTo(Utilisateur::class, 'rt_id_utilisateur', 'u_id');
    }

    public function devis() : BelongsTo {
        return $this->belongsTo(Devis::class, 'rt_id_devis', 'd_id');
    }

    public function typeDeFinition() : BelongsTo {
        return $this->belongsTo(TypeDeFinition::class, 'rt_id_type_de_finition', 'tf_id');
    }

    public function typeDeMaison() : BelongsTo {
        return $this->belongsTo(TypeDeMaison::class, 'rt_id_type_de_maison', 'tm_id');
    }

    public function avancementPaiement() : BelongsTo {
        return $this->belongsTo(AvancementPaiementPourcentage::class, 'rt_id', 'rt_id');
    }
}
