<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class TypeDeFinition extends Model
{
    use Sortable;

    protected $table = 'type_de_finition';
    public $timestamps = false;

    protected $primaryKey = 'tf_id';
    protected $fillable = [
        'tf_designation',
        'tf_augmentation_prix'
    ];

    public $sortable = [
        'tf_designation',
        'tf_augmentation_prix'
    ];

}
