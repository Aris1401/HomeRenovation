insert into genre(g_designation) values ('Homme'), ('Femme');

insert into profil_utilisateur(pu_designation) values ('BTP'), ('Client');

insert into utilisateur (
    u_nom,
    u_prenom,
    u_id_genre,
    u_date_de_naissance,
    u_email,
    u_contact,
    u_mot_de_passe,
    u_id_profil_utilisateur
) values (
    'Admin',
    'Admin',
    1,
    '1999-01-01',
    'admin@gmail.com',
    '0343444334',
    '21232f297a57a5a743894a0e4a801fc3',
    1
), (
    'John',
    'Doe',
    2,
    '2002-03-12',
    'john.doe@gmail.com',
    '0342545306',
    '527bd5b5d689e2c32ae974c6229ff785',
    2
);

insert into unite(ut_designation) values ('m3'), ('m2'), ('fft');

-- Creation devis
insert into type_de_travaux(tt_designation) values ('Travaux preparatoire'), ('Travaux de terrassement'), ('Travaux en infrastructure');
insert into type_de_finition(tf_designation, tf_augmentation_prix) values 
('Standard', 0),
('Gold', 15),
('Premium', 20),
('VIP', 50);


insert into details_devis(
    dd_id_devis,
    dd_id_type_travaux,
    dd_designation,
    dd_code_details,
    dd_id_unite,
    dd_quantite,
    dd_prix_unitaire,
    dd_montant_total,
    dd_parent
) values (
    2,
    1,
    'Mur de soutenement et demi-cloture ht 1m',
    '001',
    2,
    26.98,
    190000,
    5126200,
    null
),
(
    2,
    2,
    'Remblai ouvrage',
    '104',
    2,
    15.59,
    37563.26,
    585761.49,
    null
);

-- Mois
INSERT INTO mois (m_designation, m_position) VALUES
('Janvier', 1),
('Février', 2),
('Mars', 3),
('Avril', 4),
('Mai', 5),
('Juin', 6),
('Juillet', 7),
('Août', 8),
('Septembre', 9),
('Octobre', 10),
('Novembre', 11),
('Décembre', 12);
