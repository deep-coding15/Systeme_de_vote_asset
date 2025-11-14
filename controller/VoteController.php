<?php

class VoteController
{
    public function store($poste, $candidat, $participant)
    {
        echo "Vote enregistré : poste=$poste, candidat=$candidat, participant=$participant";
    }

    public function results()
    {
        echo "Affichage des résultats";
    }
}
