ALTER TABLE DB_SALON_Attendre RENAME TO DB_SALON_Reunions;

ALTER TABLE DB_SALON_Reunions DROP COLUMN Position_Liste;

ALTER TABLE DB_SALON_Reunions ADD Heure_Arrivee Time;

ALTER TABLE DB_SALON_Reunions ADD Numero_Reunion varchar(25) Unique;