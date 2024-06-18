-- Mise en historique des details de produits si modifier
create table historique_details_produit (
    hdp_id serial primary key,
    hdp_date_modification timestamp,
    hpd_id_details_produits int references details_devis(dd_id),
    hpd_id_devis int references devis(d_id),
    hpd_id_type_travaux int references type_de_travaux(tt_id),
    hpd_designation varchar(255),
    hpd_code_details varchar(255),
    hpd_id_unite int references unite(ut_id),
    hpd_quantite decimal(18, 5) default 0,
    hpd_prix_unitaire decimal(18, 5) default 0,
    hpd_montant_total decimal(18, 5) default 0
);