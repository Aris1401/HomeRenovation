drop table if exists import_type_maison_travaux;
drop table if exists import_realisation;
drop table if exists import_paiement;

create table import_type_maison_travaux (
    id serial primary key,
    type_maison varchar(255),
    description text,
    surface decimal(18, 5),
    code_travaux varchar(255),
    type_travaux varchar(255),
    unite varchar(255),
    prix_unitaire decimal(18, 5),
    quantite decimal(18, 5),
    duree_travaux decimal(18, 5)
);

create table import_realisation (
    id serial primary key,
    client varchar(255),
    ref_devis varchar(255),
    type_maison varchar(255),
    finition varchar(255),
    taux_finition decimal(18, 5),
    date_devis date,
    date_debut date,
    lieu varchar(255)
);

create table import_paiement (
    id serial primary key,
    ref_devis varchar(255),
    ref_paiement varchar(255),
    date_paiement date,
    montant decimal(18, 5)
);

-- Maison travaux
-- // Insertion type de maison (surface, duree, designation)
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
;

-- // Insertion de devis (type maison)
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
    tm.tm_id;


-- // Insertion unite
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
    i_tm.unite;

-- // Insertion de details devis (code travaux, designation => Type travaux
-- // prix unitaire, quantite)
insert into details_devis (dd_code_details, 
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
    );




-- Insertion realisation
-- // Insertion client
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
    i_r.client;

-- // Insertion Finition
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
    i_r.taux_finition;

-- // Insertion realisation
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
    pd.pd_ref_paiement = i_p.ref_paiement and
    pd.pd_date_de_paiement = i_p.date_paiement and
    pd.pd_montant = i_p.montant
where
    pd.pd_ref_paiement IS NULL
;

-- jkakljakljaklfjklfjsdklfjsklfjl
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
;