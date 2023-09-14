<?php 

namespace App\Model;

use Core\Model\Model;
use App\Model\Annonces;

class Photos extends Model
{
    public int $annonces_id;
    public string $image_path;

    // Associative property
    public ?Annonces $annonces;
}
