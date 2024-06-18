<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable
{
    use Sortable;

    protected $table = 'utilisateur';
    public $timestamps = false;

    protected $primaryKey = 'u_id';
    protected $fillable = [
        'u_nom',
        'u_prenom',
        'u_id_genre',
        'u_date_de_naissance',
        'u_email',
        'u_contact',
        'u_mot_de_passe',
        'u_id_profil_utilisateur'
    ];

    public $sortable = [
        'u_nom',
        'u_prenom',
        'u_id_genre',
        'u_date_de_naissance',
        'u_email',
        'u_contact',
        'u_mot_de_passe',
        'u_id_profil_utilisateur'
    ];

    public function genre() : BelongsTo {
        return $this->belongsTo(Genre::class, 'u_id_genre', 'g_id');
    }
    
    public function profilUtilisateur() : BelongsTo {
        return $this->belongsTo(ProfilUtilisateur::class, 'u_id_profil_utilisateur', 'pu_id');
    }

    public function hasRole($role) {
        if ($this->profilUtilisateur()->where('pu_designation', $role)->first()) {
            return true;
        } 

        return false;
    } 
}
