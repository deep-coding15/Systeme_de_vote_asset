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


INSERT INTO experiences_candidat (id_candidat, description) VALUES
-- 1. Nana Christelle (Présidente, Team Vision)
(1, 'Déléguée de classe pendant 3 années consécutives'),
(1, 'Organisatrice de programmes de tutorat inter-filières'),
(1, 'Responsable communication dans une association étudiante'),
(1, 'Participation active à des projets d’innovation académique'),

-- 2. Mbida Junior (Président, Team Impact)
(2, 'Coordinateur d\'événements sportifs universitaires'),
(2, 'Responsable logistique de plusieurs activités associatives'),
(2, 'Animateur d\'ateliers de leadership pour étudiants'),
(2, 'Ancien président d\'un club de débat académique'),

-- 3. Fotsing Sandra (Vice-Présidente, Team Unity)
(3, 'Membre actif du comité culturel de la faculté'),
(3, 'Animatrice de groupes de discussion pour la cohésion'),
(3, 'Bénévole dans des campagnes de sensibilisation communautaire'),
(3, 'Organisatrice d\'ateliers de bien-être étudiant'),

-- 4. Tchoua Marc (Vice-Président, Team Vision)
(4, 'Chargé de projets technologiques au sein d\'un club informatique'),
(4, 'Encadrant de hackathons et concours étudiants'),
(4, 'Responsable innovation dans une association locale'),
(4, 'Assistant animateur lors de séminaires de leadership'),

-- 5. Nkou Marie (Secrétaire Général, Team Impact)
(5, 'Secrétaire de club pendant deux années'),
(5, 'Gestion des procès-verbaux et comptes rendus d\'événements'),
(5, 'Coordinatrice de réunions interclubs'),
(5, 'Responsable de la documentation administrative'),

-- 6. Djomou Kevin (Secrétaire Général, Team Unity)
(6, 'Chargé d\'organisation dans une troupe artistique'),
(6, 'Facilitateur dans des activités de cohésion'),
(6, 'Animateur d\'ateliers pratiques pour nouveaux étudiants'),
(6, 'Expérience en médiation étudiante'),

-- 7. Ngassa Céline (Trésorière, Team Vision)
(7, 'Trésorière adjointe d\'un club universitaire'),
(7, 'Gestion de budgets pour événements étudiants'),
(7, 'Responsable de levées de fonds pour des projets sociaux'),
(7, 'Participation à des formations en comptabilité associative'),

-- 8. Kemajou Paul (Trésorier, Team Impact)
(8, 'Gestion financière d\'un club sportif'),
(8, 'Membre du comité de gestion d\'achats d\'une association'),
(8, 'Organisateur d\'opérations de collecte de fonds'),
(8, 'Expérience en suivi budgétaire et optimisation des dépenses');


INSERT INTO priorites_candidat (id_candidat, priorite) VALUES
-- 1. Nana Christelle (Présidente, Team Vision)
(1, 'Cohésion inter-filières'),
(1, 'Innovation étudiante'),
(1, 'Communication transparente avec l\'administration'),
(1, 'Partenariats professionnels'),

-- 2. Mbida Junior (Président, Team Impact)
(2, 'Organisation efficace des activités'),
(2, 'Valorisation des initiatives étudiantes'),
(2, 'Renforcement des clubs et associations'),
(2, 'Création d\'événements à fort impact'),

-- 3. Fotsing Sandra (Vice-Présidente, Team Unity)
(3, 'Renforcer l\'entraide entre étudiants'),
(3, 'Promouvoir le bien-être estudiantin'),
(3, 'Développer la communication interne'),
(3, 'Créer des espaces de dialogue'),

-- 4. Tchoua Marc (Vice-Président, Team Vision)
(4, 'Encourager l\'innovation technologique'),
(4, 'Créer des projets visionnaires'),
(4, 'Améliorer les outils numériques pour étudiants'),
(4, 'Accompagner les initiatives créatives'),

-- 5. Nkou Marie (Secrétaire Général, Team Impact)
(5, 'Structuration efficace de la communication écrite'),
(5, 'Archivage sécurisé des documents'),
(5, 'Optimisation des réunions'),
(5, 'Standardisation des procédures'),

-- 6. Djomou Kevin (Secrétaire Général, Team Unity)
(6, 'Faciliter la communication entre groupes'),
(6, 'Assurer la transparence administrative'),
(6, 'Améliorer l\'accueil des nouveaux étudiants'),
(6, 'Promouvoir la collaboration'),

-- 7. Ngassa Céline (Trésorière, Team Vision)
(7, 'Digitalisation de la gestion financière'),
(7, 'Transparence budgétaire'),
(7, 'Création de nouvelles sources de financement'),
(7, 'Optimisation des dépenses'),

-- 8. Kemajou Paul (Trésorier, Team Impact)
(8, 'Contrôle rigoureux des dépenses'),
(8, 'Optimisation des budgets'),
(8, 'Financement d\'activités innovantes'),
(8, 'Soutien financier aux projets étudiants');

UPDATE candidat SET 
description = 'Étudiante engagée et passionnée par la vie associative, Christelle possède un sens aigu de l\’organisation et de la communication. Son expérience en tant que déléguée et coordinatrice de projets lui permet de comprendre les besoins des étudiants et d\’y répondre efficacement.',
programme = 'Promouvoir une ASEET plus moderne et inclusive : améliorer la communication via des outils numériques, initier des projets d’innovation académique, renforcer la cohésion entre filières, créer des partenariats professionnels et favoriser l\’implication active des étudiants dans les décisions.'
WHERE id_candidat = 1;

UPDATE candidat SET 
description = 'Junior est reconnu comme une personne dynamique, capable de mobiliser les autres et de mener des projets concrets. Son leadership naturel et son expérience en coordination d’événements en font un excellent profil pour diriger le bureau.',
programme = 'Mettre en place un bureau efficace et centré sur les résultats : optimiser l\’organisation des activités étudiantes, valoriser les initiatives individuelles, renforcer les clubs universitaires, et instaurer un système de suivi transparent des projets associatifs.'
WHERE id_candidat = 2;

UPDATE candidat SET 
description = 'Étudiante sociable et attentive aux besoins des autres, Sandra a une forte expérience dans la cohésion et l\’accompagnement étudiant. Elle s’adapte facilement et sait fédérer autour d’objectifs communs.',
programme = 'Consolider la cohésion au sein de l’ASEET : promouvoir l\’entraide entre étudiants, organiser des activités bien-être, renforcer la communication interne, et créer des espaces d’échange dédiés au dialogue et à la médiation.'
WHERE id_candidat = 3;

UPDATE candidat SET 
description = 'Passionné par l\’innovation et la technologie, Marc est impliqué dans plusieurs projets numériques étudiants. Son sens stratégique et sa créativité font de lui un atout pour le bureau.',
programme = 'Encourager le développement d’initiatives technologiques : digitaliser certains processus de l\’ASEET, soutenir les projets innovants, organiser des compétitions académiques, et moderniser les outils de communication étudiante.'
WHERE id_candidat = 4;

UPDATE candidat SET 
description = 'Marie est rigoureuse, méthodique et possède une excellente maîtrise de la gestion administrative. Elle est reconnue pour son sens du détail et sa capacité à maintenir l\’ordre dans les processus.',
programme = 'Moderniser et structurer l’administration interne : digitaliser les archives, optimiser la gestion des réunions, standardiser les comptes-rendus, améliorer la circulation de l\’information et renforcer la transparence administrative.'
WHERE id_candidat = 5;

UPDATE candidat SET 
description = 'Kevin est une personne diplomate, toujours prête à écouter et à servir d\’intermédiaire. Son implication dans des activités de cohésion lui a donné une solide expérience en communication et en médiation.',
programme = 'Améliorer la relation entre étudiants et bureau : instaurer des points d’écoute réguliers, faciliter l\’intégration des nouveaux, organiser des ateliers participatifs et renforcer les procédures administratives collaboratives.'
WHERE id_candidat = 6;

UPDATE candidat SET 
description = 'Céline est organisée, fiable et passionnée par la gestion financière. Elle a déjà occupé des rôles similaires dans des clubs étudiants, ce qui lui confère une bonne maîtrise de la responsabilité budgétaire.',
programme = 'Repenser la gestion financière : digitaliser les comptes, mettre en place une transparence budgétaire totale, développer des stratégies de financement innovantes, et optimiser l\’utilisation des ressources de l’ASEET.'
WHERE id_candidat = 7;

UPDATE candidat SET 
description = 'Paul est une personne sérieuse avec une forte capacité d\’analyse. Habitué aux responsabilités comptables dans des associations, il est rigoureux dans la gestion et le suivi des dépenses.',
programme = 'Assurer une gestion efficace et rigoureuse : renforcer le contrôle des dépenses, optimiser les budgets des clubs, soutenir financièrement les projets prometteurs, et instaurer un système automatisé de suivi des comptes.'
WHERE id_candidat = 8;
