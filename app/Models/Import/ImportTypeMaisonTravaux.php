<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class ImportTypeMaisonTravaux extends Model
{
    use Sortable;

    protected $table = 'import_type_maison_travaux';
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $fillable = [

        'type_maison',
        'description',
        'surface',
        'code_travaux',
        'type_travaux',
        'unite',
        'prix_unitaire',
        'quantite',
        'duree_travaux',
    ];

    public $sortable = [

        'type_maison',
        'description',
        'surface',
        'code_travaux',
        'type_travaux',
        'unite',
        'prix_unitaire',
        'quantite',
        'duree_travaux',
    ];

}
