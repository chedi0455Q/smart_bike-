-- ============================================================
-- PROJET : Smart Bike PREMIUM
-- FICHIER : database.sql
-- VERSION : 2.0 — Tables étendues : produits, magasins, avis
-- ============================================================

DROP DATABASE IF EXISTS smart_bike;
CREATE DATABASE smart_bike
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE smart_bike;


-- -------------------------------------------------------
-- TABLE 1 : produits
--   Catalogue complet des vélos électriques
-- -------------------------------------------------------
CREATE TABLE produits (
    id          INT           AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)  NOT NULL,
    description TEXT          NOT NULL,
    prix        DECIMAL(8,2)  NOT NULL,
    image_url   VARCHAR(255)  NOT NULL,
    categorie   VARCHAR(50)   NOT NULL DEFAULT 'urban',   -- urban | trail | cargo | speed
    autonomie   INT           NOT NULL DEFAULT 60,        -- km
    puissance   INT           NOT NULL DEFAULT 250,       -- Watts
    poids       DECIMAL(4,1)  NOT NULL DEFAULT 18.0,      -- kg
    note        DECIMAL(2,1)  NOT NULL DEFAULT 4.5,       -- /5
    stock       INT           NOT NULL DEFAULT 10
);


-- -------------------------------------------------------
-- TABLE 2 : magasins
--   Points de vente physiques avec coordonnées GPS
-- -------------------------------------------------------
CREATE TABLE magasins (
    id          INT           AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)  NOT NULL,
    adresse     VARCHAR(255)  NOT NULL,
    ville       VARCHAR(100)  NOT NULL,
    code_postal VARCHAR(10)   NOT NULL,
    telephone   VARCHAR(20)   NOT NULL,
    email       VARCHAR(100)  NOT NULL,
    lat         DECIMAL(10,7) NOT NULL,   -- Latitude GPS
    lng         DECIMAL(10,7) NOT NULL,   -- Longitude GPS
    horaires    VARCHAR(255)  NOT NULL
);


-- -------------------------------------------------------
-- TABLE 3 : avis
--   Avis clients liés aux produits
-- -------------------------------------------------------
CREATE TABLE avis (
    id          INT           AUTO_INCREMENT PRIMARY KEY,
    produit_id  INT           NOT NULL,
    auteur      VARCHAR(80)   NOT NULL,
    note        INT           NOT NULL CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT          NOT NULL,
    date_avis   DATE          NOT NULL DEFAULT (CURRENT_DATE),
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE
);


-- -------------------------------------------------------
-- DONNÉES : 6 Vélos électriques
-- -------------------------------------------------------
INSERT INTO produits (nom, description, prix, image_url, categorie, autonomie, puissance, poids, note, stock) VALUES

('Urban Glide X1',
 'Le compagnon idéal du citadin moderne. Son cadre en aluminium 6061 T6 aéronautique et son moteur brushless de 250W vous propulsent silencieusement jusqu\'à 25 km/h. La batterie Samsung 36V/10Ah intégrée dans le tube diagonal offre jusqu\'à 60 km d\'autonomie. Freins hydrauliques Tektro, fourche rigide carbone, pneus anti-crevaison Schwalbe Marathon.',
 1299.99, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800', 'urban', 60, 250, 14.5, 4.7, 8),

('Trail Blazer Pro 500',
 'Né pour les sentiers les plus exigeants. Son moteur central Bafang M500 de 500W génère un couple de 120Nm pour dévaler ou gravir n\'importe quel terrain. Suspension intégrale Fox 34 (débattement 140mm), freins hydrauliques Shimano XT 4 pistons, transmission SRAM Eagle 12 vitesses. Batterie 48V/17.5Ah pour 80 km d\'aventure pure.',
 3499.99, 'https://images.unsplash.com/photo-1571068316344-75bc76f77890?w=800', 'trail', 80, 500, 22.0, 4.9, 4),

('City Cruiser Elegance',
 'L\'excellence à l\'état pur. Ce vélo au design Bauhaus épuré intègre le moteur central Bosch Performance Line CX (85Nm), une transmission automatique Enviolo CVT et un éclairage Supernova E3 Pro. La batterie duale 2×500Wh permet jusqu\'à 180 km sans recharger. Cadre en titane Grade 9 usiné CNC, poids : 19 kg seulement.',
 5999.00, 'https://images.unsplash.com/photo-1532298229144-0ec0c57515c7?w=800', 'urban', 180, 250, 19.0, 5.0, 2),

('Cargo Runner Max',
 'La révolution du transport urbain. Ce vélo cargo longue-queue supporte jusqu\'à 200 kg de charge utile grâce à son châssis renforcé en acier chromoly. Moteur Bosch Cargo Line 85Nm, batterie 500Wh, tube de chargement USB-C intégré. Livré avec plateforme de chargement, garde-boue intégraux et béquille centrale hydraulique.',
 2899.00, 'https://images.unsplash.com/photo-1502744688674-c619d1586c9e?w=800', 'cargo', 70, 250, 32.0, 4.5, 6),

('Speed Demon S45',
 'Pour les adeptes de vitesse légale. Homologué speed-pedelec jusqu\'à 45 km/h, il embarque un moteur Fazua Ride 60 de 60Nm parfaitement intégré dans le cadre carbone UD. Certifié EN15194 Type L1e-B, il nécessite une plaque d\'immatriculation. ABS Bosch, phares LED homologués route, rétroviseurs intégrés. Le summum de la technologie.',
 4299.00, 'https://images.unsplash.com/photo-1558618047-f4e90e1eff40?w=800', 'speed', 120, 600, 16.5, 4.8, 3),

('Folding Urban Mini',
 'La liberté en format compact. Ce vélo pliant électrique se replie en 10 secondes chrono pour vous accompagner dans le métro, le bureau ou le coffre de votre voiture. Roues de 20 pouces, moteur moyeu Shimano Steps E5000 de 250W, batterie 418Wh. Poids : seulement 14.2 kg plié. Le dernier kilomètre n\'a jamais été aussi simple.',
 1899.00, 'https://images.unsplash.com/photo-1571333250630-f0230c320b6d?w=800', 'urban', 50, 250, 14.2, 4.6, 12);


-- -------------------------------------------------------
-- DONNÉES : 4 Magasins physiques (villes françaises)
-- -------------------------------------------------------
INSERT INTO magasins (nom, adresse, ville, code_postal, telephone, email, lat, lng, horaires) VALUES

('Smart Bike Paris Marais',
 '42 Rue de Bretagne', 'Paris', '75003',
 '01 42 77 88 99', 'paris.marais@smartbike.fr',
 48.8627, 2.3607,
 'Lun-Sam 10h-19h | Dim 11h-17h'),

('Smart Bike Lyon Confluence',
 '8 Place Nautique', 'Lyon', '69002',
 '04 72 41 55 66', 'lyon@smartbike.fr',
 45.7440, 4.8193,
 'Mar-Sam 9h30-19h | Dim 10h-16h'),

('Smart Bike Bordeaux Chartrons',
 '15 Quai des Chartrons', 'Bordeaux', '33000',
 '05 56 44 22 11', 'bordeaux@smartbike.fr',
 44.8589, -0.5684,
 'Lun-Sam 10h-19h | Fermé Dim'),

('Smart Bike Marseille Vieux-Port',
 '3 Quai de Rive Neuve', 'Marseille', '13007',
 '04 91 33 44 55', 'marseille@smartbike.fr',
 43.2951, 5.3736,
 'Mar-Dim 10h-20h | Fermé Lun');


-- -------------------------------------------------------
-- DONNÉES : Avis clients
-- -------------------------------------------------------
INSERT INTO avis (produit_id, auteur, note, commentaire, date_avis) VALUES
(1, 'Thomas R.', 5, 'Incroyable rapport qualité/prix. Je fais 15 km chaque matin pour aller au travail sans transpirer. Le moteur est silencieux et l\'autonomie est au rendez-vous même en mode sport.', '2024-11-12'),
(1, 'Camille D.', 4, 'Très beau vélo, la prise en main est immédiate. Petit bémol sur le poids lors des montées d\'escalier mais en ville c\'est parfait.', '2024-12-03'),
(2, 'Marc L.', 5, 'Une bête de trail ! J\'ai parcouru des sentiers que je ne pensais pas capables de faire en VTT électrique. Les suspensions absorbent tout.', '2025-01-18'),
(3, 'Sophie M.', 5, 'Le summum. J\'ai économisé pendant 2 ans pour ce vélo et il dépasse toutes mes attentes. La qualité de finition est incomparable.', '2025-02-07'),
(5, 'Alex T.', 5, 'Je fais Paris-Versailles en moins de 30 min tous les matins. Légal, rapide, fun. Le meilleur investissement de ma vie.', '2025-03-01');

SELECT 'Installation réussie ✓' AS statut, COUNT(*) AS nb_produits FROM produits;
