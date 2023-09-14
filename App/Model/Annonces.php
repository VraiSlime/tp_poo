<?php 
namespace App\Model;

use App\Model\User;
use Core\Model\Model;
use App\Model\TypeDeLogement;

class Annonces extends Model
{
    public int $id;
    public int $user_id;
    public string $titre;
    public string $pays;
    public string $ville;
    public string $adresse;
    public int $type_de_logement_id;
    public int $taille;
    public int $nbr_de_pieces;
    public string $description;
    public int $prix_par_nuit;
    public int $nbr_de_couchages;
    
    // Associative properties
    public ?User $user;
    public ?TypeDeLogement $type_de_logement;
}
