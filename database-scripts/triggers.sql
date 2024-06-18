-- Automatisation de mis a jour de montant de devis au moment update ou insert de details 
-- de devis
create trigger on_update_details_devis_trigger 
after insert or update 
on details_devis
for each statement
execute procedure update_all_montant_devis(); 

-- Automatisation de l'historique automatique de details devis
create trigger on_update_details_devis_historique 
after update
on details_devis
for each row
execute procedure historique_details_devis();