<?php

namespace App\Model\Repository;

use Core\Repository\Repository;

class ReservationRepository extends Repository
{
    public function getTableName(): string
    {
        return 'reservations';
    }

    public function createReservation(int $annonceId, string $dateDebut, string $dateFin, int $nbrDePersonne): int
    {
        // Convertir les dates en format 'Y-m-d'
        $dateDebut = date('Y-m-d', strtotime($dateDebut));
        $dateFin = date('Y-m-d', strtotime($dateFin));

        // Vérifier si les dates sont valides
        if (!$dateDebut || !$dateFin) {
            header('Location: /error');
            exit();
        }

        // Préparation de la requête
        $sql = "INSERT INTO reservations 
                    (annonces_id, date_debut, date_fin, user_id, nbr_de_personne) 
                VALUES 
                    (?, ?, ?, ?, ?)";
        
        $values = [
            $annonceId,
            $dateDebut,
            $dateFin,
            $_SESSION['USER']->id,
            $nbrDePersonne
        ];

        $stmt = $this->pdo->prepare($sql);

        // Exécution de la requête avec les paramètres
        $stmt->execute($values);

        // Récupération de l'ID de la réservation créée
        $reservationId = $this->pdo->lastInsertId();

        return $reservationId;
    }

    public function findReservationsByUserId(int $userId): array
    {
        $query = $this->pdo->prepare('SELECT * FROM reservations WHERE user_id = ?');
        $query->execute([$userId]);

        $reservations = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $reservations;
    }

    public function getReservationsForHost($user_id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT reservations.* 
            FROM reservations 
            JOIN annonces ON reservations.annonces_id = annonces.id 
            WHERE annonces.user_id = :user_id
        ");

        $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
