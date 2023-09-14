<?php 
namespace App\Model;

use Core\Model\Model;
use App\Model\Annonces;
use App\Model\Equipement;

class AnnoncesEquipement extends Model
{
    public int $id;
    public int $equipement_id;
    public int $annonces_id;

    // Associative properties
    public ?Equipement $equipement;
    public ?Annonces $annonces;
}

