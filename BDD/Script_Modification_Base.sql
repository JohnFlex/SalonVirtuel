ALTER TABLE DB_SALON_Attendre RENAME TO DB_SALON_Reunions;

ALTER TABLE DB_SALON_Reunions DROP COLUMN Position_Liste;

ALTER TABLE DB_SALON_Reunions ADD Heure_Arrivee Time;

ALTER TABLE DB_SALON_Reunions ADD Numero_Reunion varchar(25) Unique;



ALTER TABLE DB_SALON_Presentateur ADD API_Visible_Key varchar(30);
ALTER TABLE DB_SALON_Presentateur ADD API_Hidden_Key varchar(50);
ALTER TABLE DB_SALON_Presentateur ADD Numero_Reunion varchar(100);
