<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- Importer CDN Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <!-- On link notre CSS -->
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <div id="container">
        
        <header class="custom-bg">
            <div id="top-bar" class="d-flex align-items-center">
                
                <!-- Logo Section -->
                <div class="logo-section p-5">
                    <a href="/">
                        <img src="/img/Airbnb_2010_-_logo.png" alt="Your Site Name" class="img-fluid">
                    </a>
                </div>
                
                <!-- Navigation section -->
                <nav id="nav-menu" class="menu-hidden">
                    <ul class="menu-root p-5">
                        
                        <!-- Lien vers la page d'accueil -->
                        <li>
                            <a href="/" class="btn btn-light me-2">Accueil</a>
                        </li>
                        
                        <?php
                        use App\Controller\AuthController;

                        if (AuthController::isAuth()) {
                            echo '<li class="me-2"><a href="/logout" class="btn btn-light">Déconnexion</a></li>';

                            if (AuthController::isHote()) {
                                echo '<li class="me-2"><a href="/annonces/add" class="btn btn-secondary">Ajouter une annonce</a></li>';
                                echo '<li class="me-2"><a href="/host/reservations" class="btn btn-secondary">Réservations de mes Annonces</a></li>';
                                echo '<li class="me-2"><a href="/switch-role" class="btn btn-secondary">Switcher en mode standard</a></li>';
                            } else {
                                echo '<li class="me-2"><a href="/reservations/list" class="btn btn-secondary">Mes réservations</a></li>';
                                echo '<li class="me-2"><a href="/switch-role" class="btn btn-secondary">Switcher en mode hôte</a></li>';
                            }
                        } else {
                            echo '<li class="me-2"><a href="/connexion" class="btn btn-light">Connexion</a></li>'; 
                            echo '<li class="me-2"><a href="/inscription" class="btn btn-light">Inscription</a></li>';
                        }
                        ?>
                        
                    </ul>
                </nav>
                
            </div>
            
            <hr>
            
        </header>
