<?php 
namespace App\Model\Repository;

use App\Model\Photos;
use App\Model\Annonces;
use Core\Repository\Repository;

class AnnoncesRepository extends Repository
{
    public function getTableName(): string {
        return 'annonces';
    }

    public function findAll(): array {
        return $this->readAll(Annonces::class);
    }

    public function findById(int $id) {
        return $this->readById(Annonces::class, $id);
    }

    public function findPhotoByAnnonceId(int $id): ?Photos {
        if ($id === null) {
            return null;
        }

        $query = $this->pdo->prepare('SELECT * FROM photos WHERE annonces_id = ? LIMIT 1');
        $query->execute([$id]);
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            $photo = new Photos();
            $photo->annonces_id = $data['annonces_id'];
            $photo->image_path = $data['image_path'];
            return $photo;
        }

        return null;
    }

    public function findEquipementsByAnnonceId(int $id): array {
        $query = $this->pdo->prepare(
            'SELECT e.* FROM equipement e 
            JOIN annonces_equipement ae ON ae.equipement_id = e.id 
            WHERE ae.annonces_id = ?'
        );
        $query->execute([$id]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addAnnonce(
        int $userId, 
        string $titre, 
        string $pays, 
        string $ville, 
        string $adresse, 
        int $typeDeLogementId, 
        int $taille, 
        int $nbrDePieces, 
        string $description, 
        int $prixParNuit, 
        int $nbrDeCouchages
    ): int {
        $dataToInsert = [$userId, $titre, $pays, $ville, $adresse, $typeDeLogementId, $taille, $nbrDePieces, $description, $prixParNuit, $nbrDeCouchages];
        var_dump($dataToInsert);

        $stmt = $this->pdo->prepare("
            INSERT INTO annonces 
            (user_id, titre, pays, ville, adresse, type_de_logement_id, taille, nbr_de_pieces, description, prix_par_nuit, nbr_de_couchages) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute($dataToInsert);

        echo $stmt->errorInfo()[2];

        $lastId = $this->pdo->lastInsertId();
        var_dump($lastId);

        return $lastId;
    }

    public function addPhoto(int $annonceId, string $imagePath) {
        $stmt = $this->pdo->prepare("INSERT INTO photos (annonces_id, image_path) VALUES (?, ?)");
        $stmt->execute([$annonceId, $imagePath]);
    }

    public function linkEquipementToAnnonce(int $annonceId, int $equipementId) {
        $stmt = $this->pdo->prepare("INSERT INTO annonces_equipement (annonces_id, equipement_id) VALUES (?, ?)");
        $stmt->execute([$annonceId, $equipementId]);
    }

    public function getAllEquipements(): array {
        return $this->pdo->query("SELECT * FROM equipement")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllTypesDeLogements(): array {
        return $this->pdo->query("SELECT * FROM type_de_logement")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAnnoncesByUserId(int $userId): array {
        $query = $this->pdo->prepare('SELECT * FROM annonces WHERE user_id = ?');
        $query->execute([$userId]);
        return $query->fetchAll(\PDO::FETCH_OBJ); 
    }

    public function deleteAssociatedEquipements($annonceId) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM annonces_equipement WHERE annonces_id = :id");
            $stmt->bindParam(':id', $annonceId, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            // pour debug
            echo 'PDO Exception: ' . $e->getMessage();
        }
    }

    public function deleteById($id) {
        $stmt = $this->pdo->prepare("DELETE FROM annonces WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findByTypeId(int $typeId): array {
        $query = "SELECT * FROM annonces WHERE type_de_logement_id = :typeId";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':typeId' => $typeId]);
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}
