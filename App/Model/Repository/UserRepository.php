<?php

namespace App\Model\Repository;

use App\Model\User;
use Core\Repository\Repository;

class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return 'user';
    }

    public function checkAuth(string $email, string $password): ?User
    {
        $query = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email',
            $this->getTableName()
        );

        $stmt = $this->pdo->prepare($query);

        if (!$stmt) {
            return null;
        }

        $stmt->execute(['email' => $email]);
        $user_data = $stmt->fetch();

        if ($user_data && password_verify($password, $user_data['password'])) {
            return new User($user_data);
        } else {
            return null;
        }
    }

    public function findAll(): array
    {
        return $this->readAll(User::class);
    }

    public function findById(int $id): ?User
    {
        return $this->readById(User::class, $id);
    }

    public function createUser(string $email, string $password, bool $is_hote, string $nom, string $prenom)
    {
        // Vérifie si l'email existe déjà
        $q_select = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email',
            $this->getTableName()
        );

        $stmt_select = $this->pdo->prepare($q_select);

        if (!$stmt_select) {
            return false;
        }

        $stmt_select->execute(['email' => $email]);
        $user_data = $stmt_select->fetch();

        if (!empty($user_data)) {
            return false; // Si l'email existe déjà
        }

        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertion de l'utilisateur
        $q_insert = sprintf(
            'INSERT INTO `%s` (`email`, `password`, `is_hote`, `nom`, `prenom`, `date_inscription`) 
            VALUES (:email, :password, :is_hote, :nom, :prenom, :date_inscription)',
            $this->getTableName()
        );

        $stmt_insert = $this->pdo->prepare($q_insert);

        if (!$stmt_insert) {
            return false;
        }

        $stmt_insert->execute([
            'email' => $email,
            'password' => $hashed_password,
            'is_hote' => (int)$is_hote,  // Convertir en entier ici car sinon l'inscription ne marche pas quand je veux créez un utilisateur standard 
            'nom' => $nom,
            'prenom' => $prenom,
            'date_inscription' => date('Y-m-d H:i:s')
        ]);

        return true;
    }

    public function updateUserRole(int $userId, bool $is_hote): bool
    {
        $query = sprintf(
            'UPDATE `%s` SET `is_hote` = :is_hote WHERE `id` = :id',
            $this->getTableName()
        );

        $stmt = $this->pdo->prepare($query);

        if (!$stmt) {
            return false;
        }

        return $stmt->execute(['id' => $userId, 'is_hote' => (int)$is_hote]);
    }
}
