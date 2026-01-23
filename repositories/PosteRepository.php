<?php
declare(strict_types=1);
namespace Repositories;


use Repositories\Repository;

class PosteRepository extends Repository
{
    /**
     * Récupérer tous les postes
     */
    public function getAllPostes(): array
    {
        $stmt = $this->db->query("SELECT id_poste, intitule, description FROM poste ORDER BY id_poste");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer un poste avec ses candidats
     */
    public function getPosteWithCandidats(int $id_poste): array
    {
        $posteStmt = $this->db->prepare("SELECT id_poste, intitule, description FROM poste WHERE id_poste = ?");
        $posteStmt->execute([$id_poste]);
        $poste = $posteStmt->fetch(\PDO::FETCH_ASSOC);

        if (!$poste) {
            return [];
        }

        $poste['candidats'] = $this->getCandidatsByPoste($id_poste);
        return $poste;
    }

    /**
     * Récupérer les candidats d'un poste
     */
    public function getCandidatsByPoste(int $id_poste): array
    {
        $stmt = $this->db->prepare("
            SELECT c.id_candidat, c.nom, c.prenom, c.description, c.programme, e.nom_equipe AS equipe
            FROM candidat c
            JOIN equipe e ON c.id_equipe = e.id_equipe
            WHERE c.id_poste = ?
            ORDER BY c.nom, c.prenom
        ");
        $stmt->execute([$id_poste]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Retourne la structure :
     * Poste -> Equipes -> Candidats
     */
    public function findAllWithTeamsAndCandidates(): array
    {
        $sql = "
            SELECT
                p.id_poste              AS poste_id,
                p.intitule,
                p.description,

                e.id_equipe             AS equipe_id,
                e.nom_equipe            AS equipe_nom,
                e.logo                  AS equipe_logo,

                c.id_candidat           AS candidat_id,
                c.nom                   AS candidat_nom,
                c.prenom                AS candidat_prenom,
                c.email                 AS candidat_email,
                c.description,
                c.programme,
                c.photo
            FROM candidat c 
            JOIN poste p       ON p.id_poste = c.id_poste
            JOIN equipe e     ON c.id_equipe = e.id_equipe
            ORDER BY p.id_poste, e.id_equipe, c.id_candidat
        ";

        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->hydrateHierarchy($rows);
    }

    /**
     * Construit la hiérarchie PHP à partir du résultat SQL plat
     */
    private function hydrateHierarchy(array $rows): array
    {
        $postes = [];

        foreach ($rows as $row) {
            $posteId  = (int) $row['poste_id'];
            $equipeId = (int) $row['equipe_id'];
            $candidatId = (int) $row['candidat_id'];

            // Poste
            if (!isset($postes[$posteId])) {
                $postes[$posteId] = [
                    'id'                => $posteId,
                    'intitule'          => $row['intitule'],
                    'poste_description' => $row['description'],
                    'equipes'           => []
                ];
            }

            // Équipe
            if (!isset($postes[$posteId]['equipes'][$equipeId])) {
                $postes[$posteId]['equipes'][$equipeId] = [
                    'id'    => $equipeId,
                    'nom'   => $row['equipe_nom'],
                    'logo'  => $row['equipe_logo'],
                    'candidats' => []
                ];
            }

            // Candidat
            if (!isset($postes[$posteId]['equipes'][$equipeId]['candidats'][$candidatId])) {
                $postes[$posteId]['equipes'][$equipeId]['candidats'][$candidatId] = [
                    'id'        => $candidatId,
                    'nom'       => $row['candidat_nom'],
                    'prenom'    => $row['candidat_prenom'],
                    'email'     => $row['candidat_email'],
                    'description' => $row['description'],
                    'programme'   => $row['programme'],
                    'photo'       => $row['photo']
                ];
            }
        }

        return array_values($postes);
    }
}
