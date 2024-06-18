<?php

namespace App\Services;

use App\Models\Import\ImportPaiement;
use App\Models\Import\ImportRealisation;
use App\Models\Import\ImportTypeMaisonTravaux;
use App\Models\RealisationTravaux;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ImportService
{
    public function __construct(
        protected UpdateMontantDevisService $update_montant_devis_service,
        protected RealisationTravauxService $realisation_travaux_service
    ) {
    }

    public function importerDevisClient($devis_csv, &$erreurs)
    {
        $this->update_montant_devis_service->udpateMontantDevis();

        // Erreurs
        $erronnees = 0;

        $devis = file($devis_csv->getPathname());

        $is_header = true;
        $curr_ligne = 1;

        foreach ($devis as $ligne_devis) {
            if ($is_header) {
                $is_header = false;
                continue;
            }

            $data = str_getcsv(mb_convert_encoding($ligne_devis, 'UTF-8', mb_detect_encoding($ligne_devis)), ';');

            try {
                $client = $data[0];
                $ref_devis = $data[1];
                $type_maison = $data[2];
                $finition = $data[3];
                $taux_finition = str_replace(',', '.', str_replace('%', '', $data[4]));
                $date_devis = Carbon::createFromIsoFormat('Do/MM/YYYY', $data[5])->format('Y-m-d');
                $date_debut = Carbon::createFromIsoFormat('Do/MM/YYYY', $data[6])->format('Y-m-d');
                $lieu = $data[7];

                if (Carbon::getLastErrors()['warning_count'] > 0) throw new Exception('Dates invalides');

                $data_to_insert = [
                    'client' => $client,
                    'ref_devis' => $ref_devis,
                    'type_maison' => $type_maison,
                    'finition' => $finition,
                    'taux_finition' => $taux_finition,
                    'date_devis' => $date_devis,
                    'date_debut' => $date_debut,
                    'lieu' => $lieu
                ];

                if ($taux_finition < 0) throw new Exception('Taux de finition invalide (Negatif)');

                ImportRealisation::create($data_to_insert);

                $curr_ligne++;
            } catch (Exception $e) {
                $erreurs[] = "(Devis) Erreur a la ligne " . $curr_ligne . ": " . $e->getMessage();
            } finally {
                $curr_ligne++;
            }

            if (count($erreurs) > 0) throw new Exception('(Devis) Quelques erreurs ont ete rencontrees.');
        }

        if (count($erreurs) > 0) throw new Exception('(Devis) Quelques erreurs ont ete rencontrees.');
        else {

            DB::beginTransaction();
            try {
                // Insertion client
                DB::insert('
                insert into utilisateur (
                    u_nom,
                    u_prenom,
                    u_id_genre,
                    u_date_de_naissance,
                    u_email,
                    u_contact,
                    u_mot_de_passe,
                    u_id_profil_utilisateur
                )
                select
                    i_r.client,
                    i_r.client,
                    1,
                    CURRENT_DATE,
                    i_r.client,
                    i_r.client,
                    i_r.client,
                    2
                from 
                    import_realisation as i_r
                where 
                    i_r.client not in (
                        select
                            u_contact
                        from 
                            utilisateur
                    )
                group by
                    i_r.client
                ');

                // Insertion Finition
                DB::insert('
                insert into type_de_finition (tf_designation, tf_augmentation_prix) 
                select
                    i_r.finition,
                    i_r.taux_finition
                from 
                    import_realisation as i_r
                where 
                    i_r.finition not in (
                        select
                            tf_designation
                        from 
                            type_de_finition
                    )
                group by
                    i_r.finition,
                    i_r.taux_finition
                ');

                // Insertion realisation
                $lignes_imports = ImportRealisation::leftJoin('type_de_finition', 'import_realisation.finition', '=', 'type_de_finition.tf_designation')
                    ->leftJoin('type_de_maison', 'import_realisation.type_maison', '=', 'type_de_maison.tm_designation')
                    ->leftJoin('utilisateur', 'import_realisation.client', '=', 'utilisateur.u_contact')
                    ->whereNotIn(
                        'ref_devis',
                        RealisationTravaux::select('rt_ref_devis')->groupBy('rt_ref_devis')->get()
                    )
                    ->get();
                // dd($lignes_imports);

                foreach ($lignes_imports as $import) {
                    if ($import->tm_id && $import->tf_id) {
                        $realisation_travaux = $this->realisation_travaux_service->insererReaisation(
                            $import->tm_id,
                            $import->tf_id,
                            Carbon::parse($import->date_debut),
                            $import->lieu
                        );

                        // Mettre a jour les autres donnees
                        $realisation_travaux->update([
                            'rt_id_utilisateur' => $import->u_id,
                            'rt_date_ajout_realisation' => Carbon::parse($import->date_devis),
                            'rt_ref_devis' => $import->ref_devis
                        ]);
                    }
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $erreurs[] = "Une erreur s'est produite: " . $e->getMessage();
            }
        }

        ImportRealisation::truncate();
        if (count($erreurs) > 0) throw new Exception('(Devis) Quelques erreurs ont ete rencontrees.');

        return $curr_ligne - 1;
    }

    public function importerMaisonTravaux($maison_travaux_csv, &$erreurs)
    {
        // Erreurs
        $erronnees = 0;

        $maison_travaux = file($maison_travaux_csv->getPathname());

        // Insertion travaux
        $is_header = true;
        $curr_ligne = 1;

        // dd($maison_travaux);

        foreach ($maison_travaux as $ligne_maison_travaux) {
            if ($is_header) {
                $is_header = false;
                continue;
            }

            $data = str_getcsv(mb_convert_encoding($ligne_maison_travaux, 'UTF-8', mb_detect_encoding($ligne_maison_travaux)), ';');

            $type_maison = $data[0];
            $description = $data[1];
            $surface = str_replace(",", ".", $data[2]);
            $code_travaux = $data[3];
            $type_travaux = $data[4];
            $unite = $data[5];
            $prix_unitaire = str_replace(",", ".", $data[6]);
            $quantite = str_replace(",", ".", $data[7]);
            $duree_travaux = str_replace(",", ".", $data[8]);

            try {
                if ($unite < 0 || $prix_unitaire < 0 || $quantite < 0 || $duree_travaux < 0)
                    throw new Exception("Certaines valeurs sont invalides (negatif)");

                $data_to_insert = [
                    'type_maison' => $type_maison,
                    'description' => $description,
                    'surface' => $surface,
                    'code_travaux' => $code_travaux,
                    'type_travaux' => $type_travaux,
                    'unite' => $unite,
                    'prix_unitaire' => $prix_unitaire,
                    'quantite' => $quantite,
                    'duree_travaux' => $duree_travaux,
                ];

                ImportTypeMaisonTravaux::create($data_to_insert);
            } catch (Exception $e) {
                $erreurs[] = "(Maison Travaux) Ligne " . $curr_ligne . ": " . $e->getMessage();
                $erronnees++;
            } finally {
                $curr_ligne++;
            }
        }

        if (count($erreurs) > 0) throw new Exception('(Maison travaux) Quelques erreurs ont ete rencontrees.');

        // Insertion des donnees
        DB::beginTransaction();
        try {
            // Insertion type de maison (surface, duree, designation, description)
            DB::insert('
                INSERT INTO type_de_maison (tm_designation, tm_description, tm_duree_travaux, tm_surface) 
                select
                    i_tm.type_maison,
                    i_tm.description,
                    i_tm.duree_travaux,
                    i_tm.surface
                from
                    import_type_maison_travaux as i_tm
                where
                    i_tm.type_maison not in (
                        select 
                            tm_designation
                        from 
                            type_de_maison
                    )
                group by
                    i_tm.type_maison,
                    i_tm.description,
                    i_tm.surface,
                    i_tm.duree_travaux
                ');

            // Insertion de devis (type maison)
            DB::insert('
                insert into devis (d_type_de_maison)
                select 
                    tm.tm_id
                from
                    import_type_maison_travaux as i_tm
                join
                    type_de_maison as tm
                    on tm.tm_designation = i_tm.type_maison
                where 
                    tm.tm_id not in (
                        select
                            d_type_de_maison
                        from 
                            devis
                    )
                group by
                    tm.tm_id
                ');

            // Insertion unite
            DB::insert('
                insert into unite(ut_designation)
                select
                    i_tm.unite
                from
                    import_type_maison_travaux as i_tm
                where 
                    i_tm.unite not in (
                        select 
                            ut_designation
                        from 
                            unite
                    ) 
                group by
                    i_tm.unite
                ');

            // Insertion de details devis (description, code travaux, designation => Type travaux
            // prix unitaire, quantite)
            DB::insert('
                    insert into details_devis (
                    dd_code_details, 
                    dd_designation, 
                    dd_id_unite, 
                    dd_quantite, 
                    dd_prix_unitaire, 
                    dd_id_devis,
                    dd_montant_total)
                    select
                    i_tm.code_travaux,
                    i_tm.type_travaux,
                    unite.ut_id,
                    i_tm.quantite,
                    i_tm.prix_unitaire,
                    d.d_id,
                    i_tm.quantite * i_tm.prix_unitaire as montant
                from
                    import_type_maison_travaux as i_tm
                join
                    unite
                    on i_tm.unite = unite.ut_designation
                join    
                    type_de_maison as tm
                    on tm.tm_designation = i_tm.type_maison
                join
                    devis as d
                    on d.d_type_de_maison = tm.tm_id
                where 
                    (d.d_id, i_tm.code_travaux) not in (
                        select 
                            dd_id_devis,
                            dd_code_details
                        from
                            details_devis
                        group by
                            dd_code_details,
                            dd_id_devis
                    )
                ');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $erreurs[] = "Une erreur s'est produite: " . $e->getMessage();
        }

        ImportTypeMaisonTravaux::truncate();
        $this->update_montant_devis_service->udpateMontantDevis();

        if (count($erreurs) > 0) throw new Exception('(Maison travaux) Quelques erreurs ont ete rencontrees.');

        return $curr_ligne - 1;
    }

    public function importerPaiements($paiement_csv, &$erreurs)
    {
        // Erreurs
        $erronnees = 0;

        $paiements = file($paiement_csv->getPathname());

        // Insertion travaux
        $is_header = true;
        $curr_ligne = 1;

        foreach ($paiements as $ligne_paiements) {
            if ($is_header) {
                $is_header = false;
                continue;
            }

            $data = str_getcsv(mb_convert_encoding($ligne_paiements, 'UTF-8', mb_detect_encoding($ligne_paiements)), ';');

            try {
                $ref_devis = $data[0];
                $ref_paiement = $data[1];
                $date_paiement = Carbon::createFromIsoFormat('Do/MM/YYYY', $data[2])->format('Y-m-d');
                $montant = $data[3];

                if (Carbon::getLastErrors()['warning_count'] > 0) throw new Exception('Dates invalides');

                $data_to_insert = [
                    'ref_devis' => $ref_devis,
                    'ref_paiement' => $ref_paiement,
                    'date_paiement' => $date_paiement,
                    'montant' => str_replace(',', '.', $montant),
                ];

                ImportPaiement::create($data_to_insert);
            } catch (Exception $e) {
                $erreurs[] = "(Paiement) Ligne " . $curr_ligne . ": " . $e->getMessage();
                $erronnees++;
            } finally {
                $curr_ligne++;
            }
        }

        if (count($erreurs) > 0) throw new Exception('(Paiements) Quelques erreurs ont ete rencontrees.');
        else {
            DB::beginTransaction();
            try {
                DB::insert('
                    insert into paiement_devis (pd_id_realisation_travaux, pd_date_de_paiement, pd_montant, pd_ref_paiement)
                    select
                        rt.rt_id,
                        i_p.date_paiement,
                        i_p.montant,
                        i_p.ref_paiement
                    from
                        import_paiement as i_p
                    join
                        realisation_travaux as rt
                        on rt.rt_ref_devis = i_p.ref_devis
                    left join
                        paiement_devis as pd
                        on
                        pd.pd_ref_paiement = i_p.ref_paiement
                    where
                        pd.pd_ref_paiement IS NULL
                ');

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $erreurs[] = "Une erreur s'est produite: " . $e->getMessage();
            }
        }

        ImportPaiement::truncate();
        if (count($erreurs) > 0) throw new Exception('(Paiements) Quelques erreurs ont ete rencontrees.');

        return $curr_ligne - 1;
    }
}
