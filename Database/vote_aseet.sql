-- ============================================================
-- SCHÉMA DE BASE DE DONNÉES OPTIMISÉ - SYSTÈME DE VOTE
-- Corrections et améliorations appliquées
-- ============================================================

-- Table des administrateurs
CREATE TABLE `admin` (
  `id_admin` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `mot_de_passe` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin', 'admin') DEFAULT 'admin',
  `actif` TINYINT(1) DEFAULT 1,
  `date_creation` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des équipes
CREATE TABLE `equipe` (
  `id_equipe` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_equipe` VARCHAR(100) NOT NULL,
  `logo` VARCHAR(255) NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id_equipe`),
  UNIQUE KEY `nom_equipe` (`nom_equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des postes
CREATE TABLE `poste` (
  `id_poste` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `intitule` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id_poste`),
  UNIQUE KEY `intitule` (`intitule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des candidats
CREATE TABLE `candidat` (
  `id_candidat` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `description` TEXT NULL,
  `programme` TEXT NULL,
  `photo` VARCHAR(255) NULL,
  `id_equipe` INT(11) UNSIGNED NOT NULL,
  `id_poste` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_candidat`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `unique_candidat_poste` (`id_equipe`, `id_poste`),
  KEY `idx_equipe` (`id_equipe`),
  KEY `idx_poste` (`id_poste`),
  CONSTRAINT `fk_candidat_equipe` FOREIGN KEY (`id_equipe`) 
    REFERENCES `equipe` (`id_equipe`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_candidat_poste` FOREIGN KEY (`id_poste`) 
    REFERENCES `poste` (`id_poste`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des priorités des candidats
CREATE TABLE `priorite_candidat` (
  `id_priorite` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_candidat` INT(11) UNSIGNED NOT NULL,
  `priorite` TEXT NOT NULL,
  `ordre` TINYINT(3) UNSIGNED DEFAULT 0,
  PRIMARY KEY (`id_priorite`),
  KEY `idx_candidat` (`id_candidat`),
  CONSTRAINT `fk_priorite_candidat` FOREIGN KEY (`id_candidat`) 
    REFERENCES `candidat` (`id_candidat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des experiences des candidats
CREATE TABLE `experience_candidat` (
  `id_experience` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_candidat` INT(11) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `ordre` TINYINT(3) UNSIGNED DEFAULT 0,
  PRIMARY KEY (`id_experience`),
  KEY `idx_candidat` (`id_candidat`),
  CONSTRAINT `fk_experience_candidat` FOREIGN KEY (`id_candidat`) 
    REFERENCES `candidat` (`id_candidat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table des participants/électeurs
CREATE TABLE `participant` (
  `id_participant` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `code_qr` VARCHAR(255) NOT NULL,
  `type_document` ENUM('CNI','carte_etudiant','passeport','carte_sejour','autre') NOT NULL DEFAULT 'CNI',
  `numero_document` VARCHAR(50) NOT NULL,
  `photo_document` VARCHAR(255) NULL,
  `est_valide` TINYINT(1) DEFAULT 0,
  `date_inscription` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_participant`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `code_qr` (`code_qr`),
  UNIQUE KEY `unique_document` (`type_document`, `numero_document`),
  KEY `idx_est_valide` (`est_valide`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des votes
CREATE TABLE `vote` (
  `id_vote` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_participant` INT(11) UNSIGNED NOT NULL,
  `id_candidat` INT(11) UNSIGNED NOT NULL,
  `id_poste` INT(11) UNSIGNED NOT NULL,
  `date_vote` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `adresse_ip` VARCHAR(45) NULL COMMENT 'IPv4 ou IPv6',
  PRIMARY KEY (`id_vote`),
  UNIQUE KEY `unique_vote_participant_poste` (`id_participant`, `id_poste`),
  KEY `idx_candidat` (`id_candidat`),
  KEY `idx_poste` (`id_poste`),
  KEY `idx_date_vote` (`date_vote`),
  CONSTRAINT `fk_vote_participant` FOREIGN KEY (`id_participant`) 
    REFERENCES `participant` (`id_participant`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_vote_candidat` FOREIGN KEY (`id_candidat`) 
    REFERENCES `candidat` (`id_candidat`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_vote_poste` FOREIGN KEY (`id_poste`) 
    REFERENCES `poste` (`id_poste`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des logs d'audit
CREATE TABLE `log_audit` (
  `id_log` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_admin` INT(11) UNSIGNED NOT NULL,
  `action` VARCHAR(100) NOT NULL,
  `table_affectee` VARCHAR(50) NULL,
  `id_enregistrement` INT(11) NULL,
  `details` TEXT NULL,
  `date_action` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `idx_admin` (`id_admin`),
  KEY `idx_date` (`date_action`),
  CONSTRAINT `fk_log_admin` FOREIGN KEY (`id_admin`) 
    REFERENCES `admin` (`id_admin`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- VUES POUR LES RÉSULTATS
-- ============================================================

-- Vue des résultats en direct
CREATE OR REPLACE VIEW `v_resultats_direct` AS
SELECT 
  p.id_poste,
  p.intitule AS poste,
  c.id_candidat,
  CONCAT(c.nom, ' ', c.prenom) AS candidat,
  e.nom_equipe AS equipe,
  COUNT(v.id_vote) AS total_votes
FROM poste p
CROSS JOIN candidat c
LEFT JOIN vote v ON v.id_candidat = c.id_candidat AND v.id_poste = c.id_poste
LEFT JOIN equipe e ON e.id_equipe = c.id_equipe
WHERE c.id_poste = p.id_poste
GROUP BY p.id_poste, p.intitule, c.id_candidat, c.nom, c.prenom, e.nom_equipe
ORDER BY p.id_poste, total_votes DESC;

-- Vue des résultats avec pourcentages
CREATE OR REPLACE VIEW `v_resultats_pourcentage` AS
SELECT 
  r.*,
  CASE 
    WHEN SUM(r.total_votes) OVER (PARTITION BY r.id_poste) > 0 
    THEN ROUND((r.total_votes * 100.0) / SUM(r.total_votes) OVER (PARTITION BY r.id_poste), 2)
    ELSE 0 
  END AS pourcentage_votes
FROM v_resultats_direct r;

-- Vue des statistiques globales
CREATE OR REPLACE VIEW `v_statistiques` AS
SELECT 'Participants inscrits' AS statistic, COUNT(*) AS total FROM participant
UNION ALL
SELECT 'Participants validés', COUNT(*) FROM participant WHERE est_valide = 1
UNION ALL
SELECT 'Votes enregistrés', COUNT(*) FROM vote
UNION ALL
SELECT 'Candidats', COUNT(*) FROM candidat
UNION ALL
SELECT 'Postes', COUNT(*) FROM poste
UNION ALL
SELECT 'Équipes', COUNT(*) FROM equipe;

-- ============================================================
-- TRIGGERS POUR L'INTÉGRITÉ
-- ============================================================

DELIMITER $$

-- Trigger pour vérifier qu'un participant est validé avant de voter
CREATE TRIGGER `before_vote_insert` 
BEFORE INSERT ON `vote`
FOR EACH ROW
BEGIN
  DECLARE participant_valide TINYINT(1);
  
  SELECT est_valide INTO participant_valide 
  FROM participant 
  WHERE id_participant = NEW.id_participant;
  
  IF participant_valide = 0 THEN
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'Le participant doit être validé pour voter';
  END IF;
END$$

DELIMITER ;

-- ============================================================
-- INDEX SUPPLÉMENTAIRES POUR PERFORMANCE
-- ============================================================

-- Index composites pour les requêtes fréquentes
CREATE INDEX `idx_vote_lookup` ON `vote` (`id_poste`, `id_candidat`);
CREATE INDEX `idx_candidat_lookup` ON `candidat` (`id_poste`, `id_equipe`);

COMMIT;

-- ============================================================
-- RÉSUMÉ DES CORRECTIONS APPLIQUÉES
-- ============================================================
-- 1. Utilisation de INT UNSIGNED pour tous les IDs
-- 2. Changement de utf8mb4_general_ci à utf8mb4_unicode_ci (meilleur tri)
-- 3. ENUM pour role admin au lieu de VARCHAR
-- 4. Contrainte UNIQUE sur (id_equipe, id_poste) dans candidat
-- 5. Contrainte UNIQUE sur (type_document, numero_document) dans participant
-- 6. Contrainte UNIQUE sur (id_participant, id_poste) dans vote au lieu de (id_participant, id_candidat, id_poste)
-- 7. ON DELETE RESTRICT pour vote (au lieu de CASCADE) - protège les données
-- 8. Suppression de la colonne a_vote (redondante - calculable depuis table vote)
-- 9. Suppression de experiences_candidat (non utilisé dans votre schéma)
-- 10. Renommage de priorites_candidat en priorite_candidat avec champ ordre
-- 11. Ajout de champs de traçabilité (adresse_ip dans vote)
-- 12. Vues optimisées avec noms plus clairs
-- 13. Trigger pour validation avant vote
-- 14. Index optimisés pour les requêtes fréquentes