<?php
namespace Models;

class Vote
{
    private $id_vote;
    private $id_participant;
    private $id_candidat;
    private $id_poste;
    private $date_vote;

    public function __construct(array $data)
    {
        $this->hydrateData($data);
    }

    private function hydrateData(array $data)
    {
        $this->id_vote = $data['id_vote'] ?? null;
        $this->id_participant = $data['id_participant'] ?? null;
        $this->id_candidat = $data['id_candidat'] ?? null;
        $this->id_poste = $data['id_poste'] ?? null;
        $this->date_vote = $data['date_vote'] ?? null;
    }

    /**
     * Retourne une représentation textuelle de l'objet Vote
     */
    public function toString()
    {
        return sprintf(
            "Vote #%d | IdParticipant: %d | IdCandidat: %d | IdPoste: %d | DateVote: %s",
            $this->id_vote ?? 0,
            $this->id_participant ?? 0,
            $this->id_candidat ?? 0,
            $this->id_poste ?? 0,
            $this->date_vote ?? 'N/A'
        );
    }
}
