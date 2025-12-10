<?php

namespace Models;

class Participant
{
    private $id_participant;
    private $nom;
    private $prenom;
    private $email;
    private $code_qr;
    private $est_valide;
    private $a_vote;
    private $date_inscription;

    public function __construct(array $data)
    {
        $this->hydrateData($data);
    }

    private function hydrateData(array $data)
    {
        $this->id_participant = $data['id_participant'] ?? null;
        $this->nom = $data['nom'] ?? null;
        $this->prenom = $data['prenom'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->code_qr = $data['code_qr'] ?? null;
        $this->est_valide = $data['est_valide'] ?? null;
        $this->a_vote = $data['a_vote'] ?? null;
        $this->date_inscription = $data['date_inscription'] ?? null;
    }

    /**
     * Retourne une représentation textuelle de l'objet Participant
     */
    public function toString()
    {
        return sprintf(
            "Participant #%d | IdParticipant: %d | Nom: %s | Prenom: %s | Email: %s | code_qr: %s | EstValide: %s | aVote: %s | DateInscription: %s",
            $this->id_participant ?? 0,
            $this->nom ?? 'N/A',
            $this->prenom ?? 'N/A',
            $this->email ?? 'N/A',
            $this->code_qr ?? 'N/A',
            (($this->est_valide) ? 'true' : false) ?? 'N/A',
            $this->a_vote ?? 'N/A',
            $this->date_inscription ?? 'N/A'
        );
    }

    // ID
    public function getIdParticipant() {
        return $this->id_participant;
    }

    public function setIdParticipant($id_participant) {
        $this->id_participant = $id_participant;
    }

    // Nom
    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    // Prénom
    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    // Email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    // Code QR
    public function getCodeQr() {
        return $this->code_qr;
    }

    public function setCodeQr($code_qr) {
        $this->code_qr = $code_qr;
    }

    // Compte validé ou non
    public function getEstValide() {
        return $this->est_valide;
    }

    public function setEstValide($est_valide) {
        $this->est_valide = $est_valide;
    }

    // A voté ou pas
    public function getAVote() {
        return $this->a_vote;
    }

    public function setAVote($a_vote) {
        $this->a_vote = $a_vote;
    }

    // Date d'inscription
    public function getDateInscription() {
        return $this->date_inscription;
    }

    public function setDateInscription($date_inscription) {
        $this->date_inscription = $date_inscription;
    }
}
