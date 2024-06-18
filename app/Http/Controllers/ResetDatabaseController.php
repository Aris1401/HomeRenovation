<?php

namespace App\Http\Controllers;

use App\Services\ResetBaseService;
use Exception;
use Illuminate\Http\Request;

class ResetDatabaseController extends Controller
{
    public function __construct(
        protected ResetBaseService $resetBaseService
    )
    {
        
    }

    public function index() {
        return view('reset.reset-donnees');
    }

    public function reset() {
        // Reinitialisation de la base de donnees
        try {
            $this->resetBaseService->reinitisaliserDonnees();
        } catch (Exception $e) {
            return back()->withErrors(['failed' => 'La reinitialisation des donnees a rencontrer un probleme: ' . $e->getMessage()]);
        }

        return view('reset.reset-succes');
    }
}
