INSERT INTO admin (id_admin, nom, prenom, email, mot_de_passe, role) VALUES
(1, 'Kamga', 'Lionel', 'admin1@aseet.org', 'pass123', 'superadmin'),
(2, 'Talla', 'Mireille', 'admin2@aseet.org', 'pass456', 'admin');

INSERT INTO equipe (id_equipe, nom_equipe, logo, description) VALUES
(1, 'Team Vision', 'vision.png', 'Équipe orientée innovation et vision stratégique'),
(2, 'Team Impact', 'impact.png', 'Équipe axée sur l’exécution et le résultat'),
(3, 'Team Unity', 'unity.png', 'Équipe engagée dans la cohésion et la communication');


INSERT INTO poste (id_poste, intitule, description) VALUES
(1, 'Président', 'Responsable principal du bureau ASEET'),
(2, 'Vice-Président', 'Assiste le président dans ses missions'),
(3, 'Secrétaire Général', 'Gestion administrative et coordination'),
(4, 'Trésorier', 'Responsable des finances du bureau');


INSERT INTO candidat (id_candidat, nom, prenom, email, photo, id_equipe, id_poste) VALUES
(1, 'Nana', 'Christelle', 'christelle@aseet.org', 'c1.jpg', 1, 1),
(2, 'Mbida', 'Junior', 'junior@aseet.org', 'c2.jpg', 2, 1),
(3, 'Fotsing', 'Sandra', 'sandra@aseet.org', 'c3.jpg', 3, 2),
(4, 'Tchoua', 'Marc', 'marc@aseet.org', 'c4.jpg', 1, 2),
(5, 'Nkou', 'Marie', 'marie@aseet.org', 'c5.jpg', 2, 3),
(6, 'Djomou', 'Kevin', 'kevin@aseet.org', 'c6.jpg', 3, 3),
(7, 'Ngassa', 'Céline', 'celine@aseet.org', 'c7.jpg', 1, 4),
(8, 'Kemajou', 'Paul', 'paul@aseet.org', 'c8.jpg', 2, 4);


INSERT INTO participant (id_participant, nom, prenom, email, code_qr, est_valide, a_vote, date_inscription) VALUES
(1, 'Nana', 'Sarah', 'sarah@aseet.org', 'QR001', 1, 1, '2025-11-10 10:00:00'),
(2, 'Kamdem', 'Eric', 'eric@aseet.org', 'QR002', 1, 1, '2025-11-10 10:10:00'),
(3, 'Talla', 'Chloe', 'chloe@aseet.org', 'QR003', 1, 1, '2025-11-10 10:15:00'),
(4, 'Mbouda', 'Patrick', 'patrick@aseet.org', 'QR004', 1, 1, '2025-11-10 10:20:00'),
(5, 'Fenda', 'Rita', 'rita@aseet.org', 'QR005', 1, 0, '2025-11-10 10:25:00'),
(6, 'Ngongang', 'David', 'david@aseet.org', 'QR006', 1, 0, '2025-11-10 10:30:00'),
(7, 'Manga', 'Julie', 'julie@aseet.org', 'QR007', 1, 1, '2025-11-10 10:35:00'),
(8, 'Fotso', 'Jean', 'jean@aseet.org', 'QR008', 1, 1, '2025-11-10 10:40:00'),
(9, 'Tchana', 'Grace', 'grace@aseet.org', 'QR009', 0, 0, '2025-11-10 10:45:00'),
(10, 'Biloa', 'Samuel', 'samuel@aseet.org', 'QR010', 1, 1, '2025-11-10 10:50:00'),
(11, 'Wamba', 'Luc', 'luc@aseet.org', 'QR011', 0, 0, '2025-11-10 10:55:00'),
(12, 'Noutcha', 'Kelly', 'kelly@aseet.org', 'QR012', 1, 0, '2025-11-10 11:00:00'),
(13, 'Mouafo', 'Prisca', 'prisca@aseet.org', 'QR013', 1, 1, '2025-11-10 11:05:00'),
(14, 'Kouam', 'Steve', 'steve@aseet.org', 'QR014', 1, 1, '2025-11-10 11:10:00'),
(15, 'Ze', 'Aline', 'aline@aseet.org', 'QR015', 1, 0, '2025-11-10 11:15:00');


INSERT INTO vote (id_vote, id_participant, id_candidat, id_poste, date_vote) VALUES
(1, 1, 1, 1, NOW()),
(2, 2, 2, 1, NOW()),
(3, 3, 1, 1, NOW()),
(4, 4, 2, 1, NOW()),

(5, 1, 3, 2, NOW()),
(6, 2, 3, 2, NOW()),
(7, 7, 4, 2, NOW()),

(8, 8, 5, 3, NOW()),
(9, 10, 6, 3, NOW()),
(10, 13, 6, 3, NOW()),

(11, 14, 7, 4, NOW()),
(12, 1, 8, 4, NOW());


INSERT INTO logs (id_log, id_admin, action, description, date_action) VALUES
(1, 1, 'Ajout candidat', 'Ajout du candidat Christelle', '2025-11-12 14:20:00'),
(2, 2, 'Validation participant', 'Validation du participant Sarah', '2025-11-12 15:10:00'),
(3, 1, 'Ouverture vote', 'Début officiel des votes', '2025-11-14 08:00:00');
