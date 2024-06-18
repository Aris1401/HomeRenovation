<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class Devis extends Model
{
    use Sortable;

    protected $table = 'devis';
    public $timestamps = false;

    protected $primaryKey = 'd_id';
    protected $fillable = [
        'd_date_ajout',
        'd_type_de_maison',
        'd_designation',
        'd_montant_total'
    ];

    public $sortable = [
        'd_date_ajout',
        'd_type_de_maison',
        'd_designation',
        'd_montant_total'
    ];

    public function typeDeMaison() : BelongsTo {
        return $this->belongsTo(TypeDeMaison::class, 'd_type_de_maison', 'tm_id');
    }
}
