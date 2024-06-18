-- Initialisation des montants a 0
create view v_total_devis_init as
select
    d_id,
    0 as montant
from 
    devis;

-- Total des montants de devis a partir des details
create view v_total_devis as
select
    devis.d_id,
    sum(details_devis.dd_montant_total) as montant
from details_devis
join
    devis 
        on devis.d_id = details_devis.dd_id_devis
group by devis.d_id;

-- Total des montants complets
create view v_total_devis_complet as
select 
    v_total_devis_init.d_id,
    coalesce(v_total_devis.montant, 0) as montant
from
    v_total_devis_init
left join
    v_total_devis
on 
    v_total_devis_init.d_id = v_total_devis.d_id;

-- TODO: Mettre a jour les montants des devis
update 
    devis
set d_montant_total = view.montant
from v_total_devis_complet as view
where 
    view.d_id = devis.d_id;




-- Paiement
-- Initialisation de l'avancement du paiement
create view v_avancement_paiement_init as
select
    rt_id,
    coalesce(rt_montant_total, 0) as montant_a_payer,
    0 as total_deja_payer,
    0 as reste_a_payer
from 
    realisation_travaux;

-- Total des paiements deja faits
create view v_paiements_fait as
select
    pd_id_realisation_travaux as rt_id,
    sum(pd_montant) as total_deja_payer
from
    paiement_devis
group by
    pd_id_realisation_travaux;

-- Obtenir l'avancement des paiements
create view v_avancement_paiement_complet as
select
    coalesce(v_p.rt_id, v_a.rt_id) as rt_id,
    v_a.montant_a_payer as montant_a_payer,
    coalesce(v_p.total_deja_payer, v_a.total_deja_payer) as total_deja_payer,
    v_a.montant_a_payer - coalesce(v_p.total_deja_payer, v_a.total_deja_payer) as reste_a_payer
from
    v_avancement_paiement_init as v_a
left join
    v_paiements_fait as v_p
    on v_p.rt_id = v_a.rt_id;



-- Initialisation des devis
create view v_montant_total_realisation as
select 
    sum(rt_montant_total) as montant_total
from 
    realisation_travaux;

-- Histogramme des devis par mois et annees
create view v_annees_disponible as
select
    extract(YEAR from rt_date_ajout_realisation) as annee
from 
    realisation_travaux
group by
    extract(YEAR from rt_date_ajout_realisation);

-- Inisitalisation donnees
create view v_montant_devis_mois_init as
select
    annee,
    mois.m_designation,
    mois.m_position,
    0 as montant
from 
    mois, v_annees_disponible;

-- Total des montants par mois
create view v_montant_devis_mois as
select 
    extract(YEAR from rt_date_ajout_realisation) as annee,
    extract(MONTH from rt_date_ajout_realisation) as mois,
    sum(rt_montant_total) as montant
from 
    realisation_travaux
group by
    extract(YEAR from rt_date_ajout_realisation),
    extract(MONTH from rt_date_ajout_realisation)
;

-- Total des montants complets
create view v_montant_devis_mois_complet as
select 
    v_i.annee,
    v_i.m_designation as mois,
    coalesce(v_d.montant, v_i.montant, 0) as montant
from 
    v_montant_devis_mois_init as v_i
left join
    v_montant_devis_mois as v_d
    on v_i.annee = v_d.annee and v_i.m_position = v_d.mois;



-- Paiement
create view v_avancement_paiement_complet_pourcentage as
select 
    *,
    (total_deja_payer * 100.0) / montant_a_payer as pourcentage_deja_payer,
    (reste_a_payer * 100.0) / montant_a_payer as pourcentage_reste_a_payer 
from 
    v_avancement_paiement_complet;

-- Montant total des paiements deja effectuees
create view v_montant_total_paiements as
select
    coalesce(sum(pd_montant), 0) as montant_total
from
    paiement_devis;