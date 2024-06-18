<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class Unite extends Model
{
    use Sortable;

    protected $table = 'unite';
    public $timestamps = false;

    protected $primaryKey = 'ut_id';
    protected $fillable = [

        'ut_designation'
    ];

    public $sortable = [

        'ut_designation'
    ];

}
