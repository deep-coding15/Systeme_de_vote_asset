<?php
namespace Repositories;

use chillerlan\QRCode\Output\QROutputInterface;
use Core\Session;
use Database\Database;
use Models\Participant;
use PDO;
use PDOException;


use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Utils\Utils;
/* require_once dirname(__DIR__) . '/utils/utils.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/Database/database.php';
 */

class ParticipantRepository extends Repository
{
	/* private $db;

	public function __construct()
	{
		$this->db = (new Database())->getConnection();
	} */

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

		$sql = "INSERT INTO participant (nom, prenom, email, password_hash, code_qr, phone, type_document, numero_document, photo_document, est_valide, date_inscription)
                VALUES (:nom, :prenom, :email, :password_hash, :code_qr, :phone, :type_document, :numero_document, :photo_document, :est_valide, NOW())";
		$stmt = $this->db->prepare($sql);
		$password_hash = Utils::hashPasswordBcrypt($data['password']);
		$stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR);
		$stmt->bindParam(":prenom", $data['prenom'], PDO::PARAM_STR);
		$stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
		$stmt->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
		$stmt->bindParam(":code_qr", $data['code_qr'], PDO::PARAM_STR);
		$stmt->bindParam(":phone", $data['phone'], PDO::PARAM_STR);
		$stmt->bindParam(":type_document", $data['type_document'], PDO::PARAM_STR);
		$stmt->bindParam(":numero_document", $data['numero_document'], PDO::PARAM_STR);
		$stmt->bindParam(":photo_document", $data['photo_document'], PDO::PARAM_STR);
		$stmt->bindParam(":est_valide", $data['est_valide'], PDO::PARAM_BOOL);

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
		if (!$participant) {
			return false;
		}

		error_log(print_r($participant, true));
		if (Utils::verifyPasswordBcrypt($data['password'], $participant['password_hash'])) {
			$this->update_est_valide($participant['id_participant']);
			return $participant;
		}
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
                    est_valide = :est_valide, date_inscription = :date_inscription
                WHERE id_participant = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":nom", $data['nom']);
		$stmt->bindParam(":prenom", $data['prenom']);
		$stmt->bindParam(":email", $data['email']);
		$stmt->bindParam(":code_qr", $data['code_qr']);
		$stmt->bindParam(":est_valide", $data['est_valide']);
		$stmt->bindParam(":date_inscription", $data['date_inscription']);
		$stmt->bindParam(":id", $id);

		if (!$stmt->execute()) {
			return false;
		}
		return $stmt->rowCount();
	}

	public function lockForVote(int $id)
	{
		$stmt = $this->db->prepare(
			"SELECT id_participant
         FROM participant
         WHERE id_participant = ?
         FOR UPDATE"
		);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	/* public function markAsVoted(int $id)
	{
		$stmt = $this->db->prepare(
			"UPDATE participant SET a_vote = 1 WHERE id_participant = ?"
		);
		return $stmt->execute([$id]);
	} */


	/* public function update_a_vote(int $id_participant)
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
	} */

	public function update_est_valide(int $id_participant)
	{
		$participant = $this->findById($id_participant);

		if (!$participant) {
			return false;
		}

		$sql = "UPDATE participant 
                SET est_valide = :est_valide
                WHERE id_participant = :id";

		$est_valide = 1;

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":id", $id_participant, PDO::PARAM_STR);
		$stmt->bindParam(":est_valide", $est_valide, PDO::PARAM_INT);

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
	// Incorrect
	/* public function getResultats()
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
	} */

	/* public function generateQrCode(Participant $participant)
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
	} */
}
