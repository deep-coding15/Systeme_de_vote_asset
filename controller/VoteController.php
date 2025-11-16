<?php
namespace Controller;
use Core\Response;

class VoteController
{
    public function store($poste, $candidat, $participant)
    {
        echo "Vote enregistré : poste=$poste, candidat=$candidat, participant=$participant";
    }

    public function results()
    {
        Response::render('resultats/index');
    }
}
