<?php 
namespace Models;

class Candidat{
    private $id_candidat;
    private $nom;
    private $prenom;
    private $description;
    private $email;
    private $photo;
    private $id_equipe;
    private $id_poste;
    private $created_at;
    private $modified_at;


    public function __construct(array $data)
    {
        $this->hydrateData($data);
    }

    private function hydrateData(array $data){
        $this->id_candidat = $data['id_candidat'] ?? null;
        $this->nom = $data['nom'] ?? null;
        $this->prenom = $data['prenom'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->photo = $data['photo'] ?? null;
        $this->id_equipe = $data['id_equipe'] ?? null;
        $this->id_poste = $data['id_poste'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->modified_at = $data['modified_at'] ?? null;
    }
    
}