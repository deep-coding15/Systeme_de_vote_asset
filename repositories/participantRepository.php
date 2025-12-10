<?php

namespace Repositories;

use chillerlan\QRCode\Output\QROutputInterface;
use Database\Database;
use Models\Participant;
use PDO;
use PDOException;


use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/Database/database.php';

class participantRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Récupère tous les participants
     */
    public function findAll()
    {
        $sql = "SELECT * FROM participant ORDER BY nom ASC, prenom ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouver un participant par son ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM participant WHERE id_participant = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM participant WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insérer un nouveau candidat
     */
    public function insert($data)
    {
        $data['password_hash'] = '1234'; //Juste pour le test

        $sql = "INSERT INTO participant (nom, prenom, email, password_hash, code_qr, phone, type_document, numero_document, photo_document, est_valide, a_vote, date_inscription)
                VALUES (:nom, :prenom, :email, :password_hash, :code_qr, :phone, :type_document, :numero_document, :photo_document, :est_valide, :a_vote, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR);
        $stmt->bindParam(":prenom", $data['prenom'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(":password_hash", $data['password'], PDO::PARAM_STR);
        $stmt->bindParam(":code_qr", $data['code_qr'], PDO::PARAM_STR);
        $stmt->bindParam(":phone", $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(":type_document", $data['type_document'], PDO::PARAM_STR);
        $stmt->bindParam(":numero_document", $data['numero_document'], PDO::PARAM_STR);
        $stmt->bindParam(":photo_document", $data['photo_document'], PDO::PARAM_STR);
        $stmt->bindParam(":est_valide", $data['est_valide'], PDO::PARAM_BOOL);
        $stmt->bindParam(":a_vote", $data['a_vote'], PDO::PARAM_BOOL);

        // Exécute l'insertion
        if ($stmt->execute()) {
            // Retourne l'ID inséré
            return $this->db->lastInsertId();
        }

        // En cas d'échec
        return false;
    }
    public function login($data)
    {
        //$data['password_hash'] = '1234'; //Juste pour le test
        $participant = $this->findByEmail($data['email']);
        error_log(print_r($participant, true));
        if ($participant['password_hash'] === $data['password'])
            return $participant;
        return false;
    }

    /**
     * Modifier les informations d’un candidat
     */
    public function update($id, $data)
    {
        $participant = $this->findById($id);

        if (!$participant) {
            return false;
        }

        $data = array_merge($participant, $data);
        $data['date_inscription'] = $data['date_inscription'] ?? new \DateTime();

        $sql = "UPDATE participant 
                SET nom = :nom, prenom = :prenom, email = :email, code_qr = :code_qr, 
                    est_valide = :est_valide, a_vote = :a_vote, date_inscription = :date_inscription
                WHERE id_participant = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom']);
        $stmt->bindParam(":prenom", $data['prenom']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":code_qr", $data['code_qr']);
        $stmt->bindParam(":est_valide", $data['est_valide']);
        $stmt->bindParam(":a_vote", $data['a_vote']);
        $stmt->bindParam(":date_inscription", $data['date_inscription']);
        $stmt->bindParam(":id", $id);

        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->rowCount();
    }

    public function update_a_vote(int $id_participant)
    {
        $participant = $this->findById($id_participant);

        if (!$participant) {
            return false;
        }

        if (!$participant['est_valide']) {
            return false;
        }

        $sql = "UPDATE participant 
                SET a_vote = :a_vote
                WHERE id_participant = :id";

        $a_vote = 1;

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id_participant, PDO::PARAM_STR);
        $stmt->bindParam(":a_vote", $a_vote, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->rowCount();
    }

    /**
     * Supprimer un participant
     */
    public function delete($id)
    {
        $sql = "DELETE FROM participant WHERE id_participant = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->rowCount();
    }

    /**
     * Compter le nombre total de participants
     */
    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM participant";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Chercher un participant par nom ou prénom
     */
    public function search($keyword)
    {
        $sql = "SELECT * FROM participant 
                WHERE nom LIKE :keyword OR prenom LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $search = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $search);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer les résultats (votes par participant)
     */
    public function getResultats()
    {
        $sql = "
            SELECT p.id_participant, p.nom, p.prenom, p.email, COUNT(v.id_vote) AS total_votes
            FROM participant p
            LEFT JOIN votes v ON v.id_participant = p.id_participant
            GROUP BY c.id, c.nom, c.prenom
            ORDER BY total_votes DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generateQrCode(Participant $participant)
    {

        $data = [
            'nom' => $participant->getNom(),
            'prenom' => $participant->getPrenom(),
            'email' => $participant->getEmail(),
            'est_valide' => $participant->getEstValide(),
            'a_vote' => $participant->getAVote(),
        ]; // Contenu du QR Code

        $options = new QROptions([
            'version'    => 5,
            'outputType' => QROutputInterface::GDIMAGE_PNG,
            //'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
        ]);

        header('Content-Type: image/png');
        echo (new QRCode($options))->render($data);
    }
}
/* [{
	"president": {
		"title": "President(e)",
		"candidates": [
			{
				"id": 1,
				"name": "nom candidat",
				"team": "equipe candidat",
				"photo": "photo candidat",
				"votes": 120
			}
		]
	}
},
{
	"1": {
		"id": 1,
		"intitule": "Président",
		"equipes": {
			"1": {
				"id": 1,
				"logo": "vision.png",
				"nom": "Team Vision",
				"candidats": {
					"1": {
						"id": 1,
						"nom": "Nana",
						"prenom": "Christelle",
						"email": "christelle@aseet.org",
						"description": "Étudiante engagée et passionnée par la vie associative, Christelle possède un sens aigu de l’organisation et de la communication. Son expérience en tant que déléguée et coordinatrice de projets lui permet de comprendre les besoins des étudiants et d’y répondre efficacement.",
						"programme": "Promouvoir une ASEET plus moderne et inclusive : améliorer la communication via des outils numériques, initier des projets d’innovation académique, renforcer la cohésion entre filières, créer des partenariats professionnels et favoriser l’implication active des étudiants dans les décisions.",
						"photo": "c1.jpg",
						"experiences": [
							"Déléguée de classe pendant 3 années consécutives",
							"Organisatrice de programmes de tutorat inter-filières",
							"Responsable communication dans une association étudiante",
							"Participation active à des projets d’innovation académique"
						],
						"priorites": [
							"Cohésion inter-filières",
							"Innovation étudiante",
							"Communication transparente avec l'administration",
							"Partenariats professionnels"
						]
					}
				}
			},
			"2": {
				"id": 2,
				"logo": "impact.png",
				"nom": "Team Impact",
				"candidats": {
					"2": {
						"id": 2,
						"nom": "Mbida",
						"prenom": "Junior",
						"email": "junior@aseet.org",
						"description": "Junior est reconnu comme une personne dynamique, capable de mobiliser les autres et de mener des projets concrets. Son leadership naturel et son expérience en coordination d’événements en font un excellent profil pour diriger le bureau.",
						"programme": "Mettre en place un bureau efficace et centré sur les résultats : optimiser l’organisation des activités étudiantes, valoriser les initiatives individuelles, renforcer les clubs universitaires, et instaurer un système de suivi transparent des projets associatifs.",
						"photo": "c2.jpg",
						"experiences": [
							"Coordinateur d'événements sportifs universitaires",
							"Responsable logistique de plusieurs activités associatives",
							"Animateur d'ateliers de leadership pour étudiants",
							"Ancien président d'un club de débat académique"
						],
						"priorites": [
							"Organisation efficace des activités",
							"Valorisation des initiatives étudiantes",
							"Renforcement des clubs et associations",
							"Création d'événements à fort impact"
						]
					}
				}
			}
		}
	},
	"2": {
		"id": 2,
		"intitule": "Vice-Président",
		"equipes": {
			"1": {
				"id": 1,
				"logo": "vision.png",
				"nom": "Team Vision",
				"candidats": {
					"4": {
						"id": 4,
						"nom": "Tchoua",
						"prenom": "Marc",
						"email": "marc@aseet.org",
						"description": "Passionné par l’innovation et la technologie, Marc est impliqué dans plusieurs projets numériques étudiants. Son sens stratégique et sa créativité font de lui un atout pour le bureau.",
						"programme": "Encourager le développement d’initiatives technologiques : digitaliser certains processus de l’ASEET, soutenir les projets innovants, organiser des compétitions académiques, et moderniser les outils de communication étudiante.",
						"photo": "c4.jpg",
						"experiences": [
							"Chargé de projets technologiques au sein d'un club informatique",
							"Encadrant de hackathons et concours étudiants",
							"Responsable innovation dans une association locale",
							"Assistant animateur lors de séminaires de leadership"
						],
						"priorites": [
							"Encourager l'innovation technologique",
							"Créer des projets visionnaires",
							"Améliorer les outils numériques pour étudiants",
							"Accompagner les initiatives créatives"
						]
					}
				}
			},
			"3": {
				"id": 3,
				"logo": "unity.png",
				"nom": "Team Unity",
				"candidats": {
					"3": {
						"id": 3,
						"nom": "Fotsing",
						"prenom": "Sandra",
						"email": "sandra@aseet.org",
						"description": "Étudiante sociable et attentive aux besoins des autres, Sandra a une forte expérience dans la cohésion et l’accompagnement étudiant. Elle s’adapte facilement et sait fédérer autour d’objectifs communs.",
						"programme": "Consolider la cohésion au sein de l’ASEET : promouvoir l’entraide entre étudiants, organiser des activités bien-être, renforcer la communication interne, et créer des espaces d’échange dédiés au dialogue et à la médiation.",
						"photo": "c3.jpg",
						"experiences": [
							"Membre actif du comité culturel de la faculté",
							"Animatrice de groupes de discussion pour la cohésion",
							"Bénévole dans des campagnes de sensibilisation communautaire",
							"Organisatrice d'ateliers de bien-être étudiant"
						],
						"priorites": [
							"Renforcer l'entraide entre étudiants",
							"Promouvoir le bien-être estudiantin",
							"Développer la communication interne",
							"Créer des espaces de dialogue"
						]
					}
				}
			}
		}
	},
	"4": {
		"id": 4,
		"intitule": "Trésorier",
		"equipes": {
			"1": {
				"id": 1,
				"logo": "vision.png",
				"nom": "Team Vision",
				"candidats": {
					"7": {
						"id": 7,
						"nom": "Ngassa",
						"prenom": "Céline",
						"email": "celine@aseet.org",
						"description": "Céline est organisée, fiable et passionnée par la gestion financière. Elle a déjà occupé des rôles similaires dans des clubs étudiants, ce qui lui confère une bonne maîtrise de la responsabilité budgétaire.",
						"programme": "Repenser la gestion financière : digitaliser les comptes, mettre en place une transparence budgétaire totale, développer des stratégies de financement innovantes, et optimiser l’utilisation des ressources de l’ASEET.",
						"photo": "c7.jpg",
						"experiences": [
							"Trésorière adjointe d'un club universitaire",
							"Gestion de budgets pour événements étudiants",
							"Responsable de levées de fonds pour des projets sociaux",
							"Participation à des formations en comptabilité associative"
						],
						"priorites": [
							"Digitalisation de la gestion financière",
							"Transparence budgétaire",
							"Création de nouvelles sources de financement",
							"Optimisation des dépenses"
						]
					}
				}
			},
			"2": {
				"id": 2,
				"logo": "impact.png",
				"nom": "Team Impact",
				"candidats": {
					"8": {
						"id": 8,
						"nom": "Kemajou",
						"prenom": "Paul",
						"email": "paul@aseet.org",
						"description": "Paul est une personne sérieuse avec une forte capacité d’analyse. Habitué aux responsabilités comptables dans des associations, il est rigoureux dans la gestion et le suivi des dépenses.",
						"programme": "Assurer une gestion efficace et rigoureuse : renforcer le contrôle des dépenses, optimiser les budgets des clubs, soutenir financièrement les projets prometteurs, et instaurer un système automatisé de suivi des comptes.",
						"photo": "c8.jpg",
						"experiences": [
							"Gestion financière d'un club sportif",
							"Membre du comité de gestion d'achats d'une association",
							"Organisateur d'opérations de collecte de fonds",
							"Expérience en suivi budgétaire et optimisation des dépenses"
						],
						"priorites": [
							"Contrôle rigoureux des dépenses",
							"Optimisation des budgets",
							"Financement d'activités innovantes",
							"Soutien financier aux projets étudiants"
						]
					}
				}
			}
		}
	},
	"3": {
		"id": 3,
		"intitule": "Secrétaire Général",
		"equipes": {
			"2": {
				"id": 2,
				"logo": "impact.png",
				"nom": "Team Impact",
				"candidats": {
					"5": {
						"id": 5,
						"nom": "Nkou",
						"prenom": "Marie",
						"email": "marie@aseet.org",
						"description": "Marie est rigoureuse, méthodique et possède une excellente maîtrise de la gestion administrative. Elle est reconnue pour son sens du détail et sa capacité à maintenir l’ordre dans les processus.",
						"programme": "Moderniser et structurer l’administration interne : digitaliser les archives, optimiser la gestion des réunions, standardiser les comptes-rendus, améliorer la circulation de l’information et renforcer la transparence administrative.",
						"photo": "c5.jpg",
						"experiences": [
							"Secrétaire de club pendant deux années",
							"Gestion des procès-verbaux et comptes rendus d'événements",
							"Coordinatrice de réunions interclubs",
							"Responsable de la documentation administrative"
						],
						"priorites": [
							"Structuration efficace de la communication écrite",
							"Archivage sécurisé des documents",
							"Optimisation des réunions",
							"Standardisation des procédures"
						]
					}
				}
			},
			"3": {
				"id": 3,
				"logo": "unity.png",
				"nom": "Team Unity",
				"candidats": {
					"6": {
						"id": 6,
						"nom": "Djomou",
						"prenom": "Kevin",
						"email": "kevin@aseet.org",
						"description": "Kevin est une personne diplomate, toujours prête à écouter et à servir d’intermédiaire. Son implication dans des activités de cohésion lui a donné une solide expérience en communication et en médiation.",
						"programme": "Améliorer la relation entre étudiants et bureau : instaurer des points d’écoute réguliers, faciliter l’intégration des nouveaux, organiser des ateliers participatifs et renforcer les procédures administratives collaboratives.",
						"photo": "c6.jpg",
						"experiences": [
							"Chargé d'organisation dans une troupe artistique",
							"Facilitateur dans des activités de cohésion",
							"Animateur d'ateliers pratiques pour nouveaux étudiants",
							"Expérience en médiation étudiante"
						],
						"priorites": [
							"Faciliter la communication entre groupes",
							"Assurer la transparence administrative",
							"Améliorer l'accueil des nouveaux étudiants",
							"Promouvoir la collaboration"
						]
					}
				}
			}
		}
	}
}]

[{
  "president": {
    "title": "President(e)",
    "candidates": [
      {
        "id": 1,
        "name": "nom candidat",
        "team": "equipe candidat",
        "photo": "photo candidat",
        "votes": 120
      }
    ]
  }
}]
 */