<?php 
namespace App\Model;

use Core\Model\Model;

class User extends Model
{
     public const ROLE_HOTE = 1;
     public const ROLE_STANDARD = 2;

    public int $id;
    public string $password;
    public string $email;
    public bool $is_hote;
    public string $nom;
    public string $prenom;
    public string $date_inscription;
}
