<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class ImportPaiement extends Model
{
    use Sortable;

    protected $table = 'import_paiement';
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $fillable = [

        'ref_devis',
        'ref_paiement',
        'date_paiement',
        'montant',
    ];

    public $sortable = [

        'ref_devis',
        'ref_paiement',
        'date_paiement',
        'montant',
    ];

}
