<?php 
namespace Models;

class Equipe{
    private $id_equipe;
    private $nom_equipe;
    private $logo_path;
    private $description;

    /**
     * Summary of __construct
     * @param array $data = ['id_equipe', 'nom_equipe', 'logo_path', 'description']
     */
    public function __construct(array $data)
    {
        $this->hydrateData($data);
    }

    private function hydrateData(array $data){
        $this->id_equipe = $data['id_equipe'] ?? null;
        $this->nom_equipe = $data['nom_equipe'] ?? null;
        $this->logo_path = $data['logo_path'] ?? null;
        $this->description = $data['description'] ?? null;
    }
    
    /**
     * Retourne une représentation textuelle de l'objet Vote
     */
    public function toString()
    {
        return sprintf(
            "Equipe #%d | NomEquipe: %s | LogoPath: %s | Description: %s",
            $this->id_equipe ?? 0,
            $this->nom_equipe ?? 'N/A',
            $this->logo_path ?? 0,
            $this->description ?? 'N/A',
        );
    }
}