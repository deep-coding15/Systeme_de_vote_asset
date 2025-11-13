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
}
