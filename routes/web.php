<?php

use App\Exports\TestPage;
use App\Http\Controllers\DetailsDevisController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\InsertionDonneesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RealisationTravauxAdminController;
use App\Http\Controllers\RealisationTravauxController;
use App\Http\Controllers\ResetDatabaseController;
use App\Http\Controllers\TableauDeBordController;
use App\Http\Controllers\TypeDeFinitionController;
use App\Http\Controllers\TypeDeMaisonController;
use App\Http\Controllers\UniteController;
use App\Models\Genre;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Kyslik\ColumnSortable\ColumnSortableServiceProvider;
use Maatwebsite\Excel\Facades\Excel;

Route::middleware('auth')->group(function() {
    // Tableau de bord
    Route::get('/', [TableauDeBordController::class, 'index'])->name('tableau-de-bord')->middleware('checkRole:BTP');

    // Reinitialisation des donnees
    Route::get('/reset', [ResetDatabaseController::class, 'index'])->name('reset-index')->middleware('checkRole:BTP');
    Route::get('/reset/execute', [ResetDatabaseController::class, 'reset'])->name('reset-database')->middleware('checkRole:BTP');

    // Unites
    Route::get('/unites', [UniteController::class, 'index'])->name('unites.index')->middleware('checkRole:BTP');
    Route::get('/unites/create', [UniteController::class, 'create'])->name('unites.create')->middleware('checkRole:BTP');
    Route::post('/unites', [UniteController::class,'store'])->name('unites.store')->middleware('checkRole:BTP');
    Route::get('/unites/{id}/edit', [UniteController::class,'edit'])->name('unites.edit')->middleware('checkRole:BTP');
    Route::put('/unites/{id}', [UniteController::class,'update'])->name('unites.update')->middleware('checkRole:BTP');
    Route::delete('/unites/{id}', [UniteController::class, 'destroy'])->name('unites.delete')->middleware('checkRole:BTP');

    // Types de maison
    Route::get('/type-maison', [TypeDeMaisonController::class, 'index'])->name('type-maison.index')->middleware('checkRole:BTP');
    Route::get('/type-maison/create', [TypeDeMaisonController::class, 'create'])->name('type-maison.create')->middleware('checkRole:BTP');
    Route::post('/type-maison', [TypeDeMaisonController::class,'store'])->name('type-maison.store')->middleware('checkRole:BTP');
    Route::get('/type-maison/{id}/edit', [TypeDeMaisonController::class,'edit'])->name('type-maison.edit')->middleware('checkRole:BTP');
    Route::put('/type-maison/{id}', [TypeDeMaisonController::class,'update'])->name('type-maison.update')->middleware('checkRole:BTP');
    Route::delete('/type-maison/{id}', [TypeDeMaisonController::class, 'destroy'])->name('type-maison.delete')->middleware('checkRole:BTP');

    // Type de finitions
    Route::get('/type-de-finition', [TypeDeFinitionController::class, 'index'])->name('type-de-finition.index')->middleware('checkRole:BTP');
    Route::get('/type-de-finition/{id}/edit', [TypeDeFinitionController::class,'edit'])->name('type-de-finition.edit')->middleware('checkRole:BTP');
    Route::put('/type-de-finition/{id}', [TypeDeFinitionController::class,'update'])->name('type-de-finition.update')->middleware('checkRole:BTP');


    // Liste des devis du client
    Route::get('/realiser', [RealisationTravauxController::class, 'create'])->name('realiser');
    Route::post('/realiser/store', [RealisationTravauxController::class, 'store'])->name('realiser.store');
    Route::get('/realisation', [RealisationTravauxController::class, 'index'])->name('realisaiton');
    Route::get('/realisation/{id}/paiement', [RealisationTravauxController::class, 'paiement'])->name('realisation.paiement');
    Route::post('/realisation/{id}/valider-paiement', [RealisationTravauxController::class, 'validerPaiement'])->name('realisation.valider.paiement');
    Route::post('/realisation/{id}/payer', [RealisationTravauxController::class, 'effectuerPaiement'])->name('realisation.payer');
    Route::get('/realisation/{id}/exporter', [RealisationTravauxController::class, 'export'])->name('realisation.export');

    // Liste des devis
    Route::get('/devis', [DevisController::class, 'index'])->name('devis.index');
    Route::get('/devis/create', [DevisController::class, 'create'])->name('devis.create');
    Route::post('/devis', [DevisController::class, 'store'])->name('devis.store');
    Route::get('/devis/{id}', [DevisController::class, 'show'])->name('devis.show');
    Route::get('/devis/{id}/travaux', [DetailsDevisController::class, 'index'])->name('devis.travaux.ajout');

    // Details devis
    Route::get('/details-devis', [DetailsDevisController::class, 'liste'])->name('details-devis.index')->middleware('checkRole:BTP');
    Route::get('/details-devis/{id}/edit', [DetailsDevisController::class, 'edit'])->name('details-devis.edit')->middleware('checkRole:BTP');
    Route::put('/details-devis/{id}', [DetailsDevisController::class, 'update'])->name('details-devis.update')->middleware('checkRole:BTP');

    // Admin
    Route::get('/admin/devis', [RealisationTravauxAdminController::class, 'index'])->name('realisations.admin')->middleware('checkRole:BTP')->middleware('checkRole:BTP');
    Route::get('/admin/devis/{id}', [RealisationTravauxAdminController::class, 'details'])->name('realisations.admin.details')->middleware('checkRole:BTP')->middleware('checkRole:BTP');

    // Import des donnees
    Route::get('/import/maison-travaux', [InsertionDonneesController::class, 'showMaisonTravauxDevis'])->name('import.maison-travaux')->middleware('checkRole:BTP');
    Route::post('/import/maison-travaux/inserer', [InsertionDonneesController::class, 'importerMaisonTravauxDevis'])->name('import.maison-travaux.inserer')->middleware('checkRole:BTP');

    Route::get('/import/paiement', [InsertionDonneesController::class, 'showPaiement'])->name('import.paiement')->middleware('checkRole:BTP');
    Route::post('/import/paiement/inserer', [InsertionDonneesController::class, 'importerPaiement'])->name('import.paiement.inserer')->middleware('checkRole:BTP');

});

// Login et creation utilisateur
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/authenticate', [LoginController::class,'authenticate'])->name('authenticate');

Route::get('/login/admin', [LoginController::class, 'indexAdmin'])->name('login.admin');
Route::post('/authenticate/admin', [LoginController::class,'authenticateAdmin'])->name('authenticate.admin');

Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');
Route::get('/register', function() {
    $genres = Genre::all();

    return view('register')->with('genres', $genres);
});
Route::post('/register', [LoginController::class, 'register'])->name('register');
