<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class TypeDeTravaux extends Model
{
    use Sortable;

    protected $table = 'type_de_travaux';
    public $timestamps = false;

    protected $primaryKey = 'tt_id';
    protected $fillable = [
        'tt_designation'
    ];

    public $sortable = [
        'tt_designation'
    ];

}
