<?php

namespace App\Controller;

use Core\View\View;
use Core\Session\Session;
use Core\Repository\AppRepoManager;
use App\Model\Repository\AnnoncesRepository;

class HomeController {

    public function index() {
        if (AuthController::isHote()) {
            // L'utilisateur est un hôte, récupérez ses annonces
            $userId = Session::get(Session::USER)->id;
            $annonces = AppRepoManager::getRm()->getAnnoncesRepo()->getAnnoncesByUserId($userId);
        } else {
            // L'utilisateur est standard, récupérez toutes les annonces
            $annonces = AppRepoManager::getRm()->getAnnoncesRepo()->findAll();
        }

        // Récupérer les photos pour chaque annonce
        foreach ($annonces as $annonce) {
            $annonce->photo = AppRepoManager::getRm()->getAnnoncesRepo()->findPhotoByAnnonceId($annonce->id);
        }

        $view_data = [
            'title_tag' => 'Accueil',
            'list_title' => 'Listes des annonces',
            'annonces' => $annonces
        ];

        $view = new View('pages/home');
        $view->title = 'Accueil';
        $view->render($view_data);
    }

    public function deleteAnnonce($id) {
        $annonceRepo = AppRepoManager::getRm()->getAnnoncesRepo();

        // Vérifier d'abord si l'annonce appartient à l'utilisateur actuellement authentifié
        $annonce = $annonceRepo->findById($id);
        if (!$annonce || $annonce->user_id != Session::get(Session::USER)->id) {
            // Redirige vers accueil
            header('Location: /');
            exit;
        }

        // Supprimez l'annonce
        $annonceRepo->deleteAssociatedEquipements($id);
        $annonceRepo->deleteById($id);

        // Redirige vers la page d'accueil avec un message de succès
        header('Location: /?message=Annonce supprimée avec succès.');
        exit;
    }
}
