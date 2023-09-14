<?php 

namespace App\Model;

use Core\Model\Model;

class Reservations extends Model
{
    public int $id;
    public int $user_id;
    public int $annonces_id;
    public int $date_debut;
    public int $date_fin;
    public int $nbr_de_personne;

    // Associative properties
    public ?User $user;
    public ?Annonces $annonces;
}
