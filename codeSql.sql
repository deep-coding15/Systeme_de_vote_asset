-- ========================================
-- Base de données : systeme_vote_aseet
-- ========================================

CREATE DATABASE IF NOT EXISTS systeme_vote_aseet;
USE systeme_vote_aseet;

-- ========================================
-- Table : admin
-- ========================================
CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin'
);

-- ========================================
-- Table : participant
-- ========================================
CREATE TABLE participant (
    id_participant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    code_qr VARCHAR(255) NOT NULL UNIQUE,
    est_valide BOOLEAN DEFAULT FALSE,
    a_vote BOOLEAN DEFAULT FALSE,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ========================================
-- Table : equipe
-- ========================================
CREATE TABLE equipe (
    id_equipe INT AUTO_INCREMENT PRIMARY KEY,
    nom_equipe VARCHAR(100) NOT NULL UNIQUE,
    logo VARCHAR(255),
    description TEXT
);

-- ========================================
-- Table : poste
-- ========================================
CREATE TABLE poste (
    id_poste INT AUTO_INCREMENT PRIMARY KEY,
    intitule VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- ========================================
-- Table : candidat
-- ========================================
CREATE TABLE candidat (
    id_candidat INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    photo VARCHAR(255),
    id_equipe INT NOT NULL,
    id_poste INT NOT NULL,
    FOREIGN KEY (id_equipe) REFERENCES equipe(id_equipe) ON DELETE CASCADE,
    FOREIGN KEY (id_poste) REFERENCES poste(id_poste) ON DELETE CASCADE
);

-- ========================================
-- Table : vote
-- ========================================
CREATE TABLE vote (
    id_vote INT AUTO_INCREMENT PRIMARY KEY,
    id_participant INT NOT NULL,
    id_candidat INT NOT NULL,
    id_poste INT NOT NULL,
    date_vote DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (id_participant, id_candidat, id_poste),
    FOREIGN KEY (id_poste) REFERENCES poste(id_poste) ON DELETE CASCADE,
    FOREIGN KEY (id_participant) REFERENCES participant(id_participant) ON DELETE CASCADE,
    FOREIGN KEY (id_candidat) REFERENCES candidat(id_candidat) ON DELETE CASCADE
);

-- ========================================
-- Table : logs
-- ========================================
CREATE TABLE logs (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_admin INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    description TEXT,
    date_action DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_admin) REFERENCES admin(id_admin) ON DELETE CASCADE
);

-- ========================================
-- Vues : resultats_en_direct
-- ========================================
CREATE OR REPLACE VIEW resultats_en_direct AS
SELECT 
    p.id_poste,
    p.intitule AS poste,
    c.id_candidat,
    CONCAT(c.nom, ' ', c.prenom) AS candidat,
    e.nom_equipe AS equipe,
    COUNT(v.id_vote) AS total_votes
FROM vote v
JOIN candidat c ON v.id_candidat = c.id_candidat
JOIN poste p ON v.id_poste = p.id_poste
JOIN equipe e ON c.id_equipe = e.id_equipe
GROUP BY p.id_poste, p.intitule, c.id_candidat, c.nom, c.prenom, e.nom_equipe
ORDER BY p.id_poste, total_votes DESC;

-- ========================================
-- Vues : resultats_en_direct_pourcentage
-- ========================================
CREATE OR REPLACE VIEW resultats_en_direct_pourcentage AS
SELECT 
    p.id_poste,
    p.intitule AS poste,
    c.id_candidat,
    CONCAT(c.nom, ' ', c.prenom) AS candidat,
    e.nom_equipe AS equipe,
    COUNT(v.id_vote) AS total_votes,
    ROUND( (COUNT(v.id_vote) * 100.0) / 
           (SELECT COUNT(*) 
            FROM vote v2 
            WHERE v2.id_poste = p.id_poste), 2) AS pourcentage_votes
FROM vote v
JOIN candidat c ON v.id_candidat = c.id_candidat
JOIN poste p ON v.id_poste = p.id_poste
JOIN equipe e ON c.id_equipe = e.id_equipe
GROUP BY p.id_poste, p.intitule, c.id_candidat, c.nom, c.prenom, e.nom_equipe
ORDER BY p.id_poste, total_votes DESC;
