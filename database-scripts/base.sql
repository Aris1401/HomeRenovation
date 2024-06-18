-- Creation de base
create database home_renovation;

-- Table utilisateur
create table genre (
    g_id serial primary key,
    g_designation varchar(255)
);

create table profil_utilisateur (
    pu_id serial primary key,
    pu_designation varchar(255)
);

create table utilisateur (
    u_id serial primary key,
    u_nom varchar(255),
    u_prenom varchar(255),
    u_id_genre int references genre(g_id),
    u_date_de_naissance date,
    u_email varchar(255),
    u_contact varchar(10),
    u_mot_de_passe varchar(255),
    u_id_profil_utilisateur int references profil_utilisateur(pu_id)
);

-- 
create table unite (
    ut_id serial primary key,
    ut_designation varchar(255)
);

create table type_de_finition (
    tf_id serial primary key,
    tf_designation varchar(255),
    tf_augmentation_prix decimal(18, 5)
);

create table type_de_maison (
    tm_id serial primary key,
    tm_designation varchar(255),
    tm_description text,
    tm_duree_travaux decimal(18, 2)
);

create table type_de_travaux (
    tt_id serial primary key,
    tt_designation varchar(255)
);

create table devis (
    d_id serial primary key,
    d_date_ajout timestamp default CURRENT_TIMESTAMP,
    d_type_de_maison int references type_de_maison(tm_id),
    d_designation varchar(255),
    d_montant_total decimal(18, 5)
);

create table details_devis (
    dd_id serial primary key,
    dd_id_devis int references devis(d_id),
    dd_id_type_travaux int references type_de_travaux(tt_id),
    dd_designation varchar(255),
    dd_code_details varchar(255),
    dd_id_unite int references unite(ut_id),
    dd_quantite decimal(18, 5) default 0,
    dd_prix_unitaire decimal(18, 5) default 0,
    dd_montant_total decimal(18, 5) default 0,
    dd_parent int
);

create table realisation_travaux (
    rt_id serial primary key,
    rt_id_utilisateur int references utilisateur(u_id),
    rt_id_devis int references devis(d_id),
    rt_id_type_de_maison int references type_de_maison(tm_id),
    rt_id_type_de_finition int references type_de_finition(tf_id),
    rt_date_ajout_realisation timestamp default CURRENT_TIMESTAMP,
    rt_date_debut_travaux timestamp,
    rt_date_fin_travaux timestamp,
    rt_montant_total decimal,
    rt_augmentation decimal,
    rt_duree_travail decimal
);

create table details_realisation (
    dr_id serial primary key,
    dr_id_realisation_travaux int references realisation_travaux(rt_id),
    dr_id_type_travaux int references type_de_travaux(tt_id),
    dr_designation varchar(255),
    dr_code_details varchar(255),
    dr_id_unite int references unite(ut_id),
    dr_quantite decimal(18, 5) default 0,
    dr_prix_unitaire decimal(18, 5) default 0,
    dr_montant_total decimal(18, 5) default 0,
    dr_parent int
);

create table paiement_devis (
    pd_id serial primary key,
    pd_id_realisation_travaux int references realisation_travaux(rt_id),
    pd_date_de_paiement timestamp,
    pd_montant decimal(18, 2)
);

create table mois (
    m_id serial primary key,
    m_designation varchar(255),
    m_position int
);

alter table type_de_maison add column tm_surface decimal(18, 5);

alter table realisation_travaux add column rt_ref_devis varchar(255);
alter table realisation_travaux add column rt_lieu varchar(255);

alter table details_devis add column dd_description DECIMAL(18, 5);

alter table details_realisation add column dr_description DECIMAL(18, 5);

alter table paiement_devis add column pd_ref_paiement varchar(255);

