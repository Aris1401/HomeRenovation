<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

class TypeDeMaison extends Model
{
    use Sortable;

    protected $table = 'type_de_maison';
    public $timestamps = false;

    protected $primaryKey = 'tm_id';
    protected $fillable = [
        'tm_designation',
        'tm_description',
        'tm_duree_travaux',
        'tm_surface'
    ];

    public $sortable = [
        'tm_designation',
        'tm_description',
        'tm_duree_travaux',
        'tm_surface'
    ];

    public function devis() {
        return $this->hasMany(Devis::class, 'd_type_de_maison', 'tm_id');
    }
}
