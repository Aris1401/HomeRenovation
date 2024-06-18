<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class ProfilUtilisateur extends Model
{
    use Sortable;

    protected $table = 'profil_utilisateur';
    public $timestamps = false;

    protected $primaryKey = 'pu_id';
    protected $fillable = [
        'pu_designation'
    ];

    public $sortable = [
        'pu_designation'
    ];

}
