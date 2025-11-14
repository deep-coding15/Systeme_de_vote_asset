<?php

class ParticipantController
{
    public function index()
    {
        echo "Liste des participants";
    }

    public function store()
    {
        echo "Enregistrement participant";
    }

    public function validate($id)
    {
        echo "Validation du participant ID = $id";
    }
}
