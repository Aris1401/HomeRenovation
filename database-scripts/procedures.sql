-- Fonction permettant de mettre a jour les montants total des devis au moment de modification
-- ou d'ajout de travaux a un devis specifier
create function update_all_montant_devis() returns TRIGGER as $$
begin
    update 
        devis
    set d_montant_total = view.montant
    from v_total_devis_complet as view
    where 
        view.d_id = devis.d_id;
    
    return new;
end;
$$ language plpgsql;

-- Fonction pour historiser les modification dans la table details produits
create function historique_details_devis() returns TRIGGER as $$
begin

    insert into historique_details_produit(
        hdp_date_modification,
        hpd_id_details_produits,
        hpd_id_devis,
        hpd_id_type_travaux,
        hpd_designation,
        hpd_code_details,
        hpd_id_unite,
        hpd_quantite,
        hpd_prix_unitaire,
        hpd_montant_total
    ) values (
        CURRENT_TIMESTAMP,
        old.dd_id,
        old.dd_id_devis,
        old.dd_id_type_travaux,
        old.dd_designation,
        old.dd_code_details,
        old.dd_id_unite,
        old.dd_quantite,
        old.dd_prix_unitaire,
        old.dd_montant_total
    );

return new;
end;
$$ language plpgsql;