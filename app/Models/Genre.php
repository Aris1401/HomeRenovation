<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class Genre extends Model
{
    use Sortable;

    protected $table = 'genre';
    public $timestamps = false;

    protected $primaryKey = 'g_id';
    protected $fillable = [
        'g_designation'
    ];

    public $sortable = [
        'g_designation'
    ];

}
