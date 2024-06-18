<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class ImportRealisation extends Model
{
    use Sortable;

    protected $table = 'import_realisation';
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $fillable = [

        'client',
        'ref_devis',
        'type_maison',
        'finition',
        'taux_finition',
        'date_devis',
        'date_debut',
        'lieu',
    ];

    public $sortable = [

        'client',
        'ref_devis',
        'type_maison',
        'finition',
        'taux_finition',
        'date_devis',
        'date_debut',
        'lieu',
    ];

}
