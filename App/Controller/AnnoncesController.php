<?php

namespace App\Controller;

use Core\View\View;
use Core\Session\Session;
use Core\Repository\AppRepoManager;

class AnnoncesController {

    public function showDetail(int $id) {
        $annonce = AppRepoManager::getRm()->getAnnoncesRepo()->findById($id);
        $photo = AppRepoManager::getRm()->getAnnoncesRepo()->findPhotoByAnnonceId($id);
        $equipements = AppRepoManager::getRm()->getAnnoncesRepo()->findEquipementsByAnnonceId($id);

        $view_data = [
            'annonce' => $annonce,
            'photo' => $photo,
            'equipements' => $equipements
        ];

        $view = new View('pages/detail');
        $view->title = 'Détails de l\'annonce';
        $view->render($view_data);
    }

    public function showAddForm() {
        $equipements = AppRepoManager::getRm()->getAnnoncesRepo()->getAllEquipements();
        $typesDeLogements = AppRepoManager::getRm()->getAnnoncesRepo()->getAllTypesDeLogements();

        $view = new View('pages/add_annonce');
        $view->title = 'Ajouter une annonce';
        $view->render(['equipements' => $equipements, 'typesDeLogements' => $typesDeLogements]);
    }

    public function store() {
        var_dump($_SESSION);

        if (isset($_SESSION['FORM_RESULT']->form_errors)) {
            var_dump($_SESSION['FORM_RESULT']->form_errors);
        }

        if (isset($_SESSION['FORM_RESULT']) && method_exists($_SESSION['FORM_RESULT'], 'getErrors')) {
            $errors = $_SESSION['FORM_RESULT']->getErrors();
            var_dump($errors);
        }

        if (!isset($_SESSION['USER']) || $_SESSION['USER']->is_hote !== true) {
            header("Location: /connexion");
        }

        $userId = $_SESSION['USER']->id;

        // Collecte des données de l'annonce
        $title = $_POST['titre'];
        $description = $_POST['description'];
        $pays = $_POST['pays'];
        $ville = $_POST['ville'];
        $adresse = $_POST['adresse'];
        $taille = $_POST['taille'];
        $nbrDePieces = $_POST['nbr_de_pieces'];
        $prixParNuit = $_POST['prix_par_nuit'];
        $nbrDeCouchages = $_POST['nbr_de_couchages'];
        $typeDeLogementId = $_POST['type_de_logement_id'];

        // Conversion en entier sinon ca bug 
        $typeDeLogementId = (int) $typeDeLogementId;

        $annonceId = AppRepoManager::getRm()->getAnnoncesRepo()->addAnnonce($userId, $title, $pays, $ville, $adresse, $typeDeLogementId, $taille, $nbrDePieces, $description, $prixParNuit, $nbrDeCouchages);

        var_dump($annonceId);

        if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $photoName = $_FILES['photo']['name'];
            $publicImgPath = 'img/' . $photoName;
            echo $publicImgPath;
            move_uploaded_file($_FILES['photo']['tmp_name'], "img/" . $photoName);
            AppRepoManager::getRm()->getAnnoncesRepo()->addPhoto($annonceId, $publicImgPath);
        }

        $equipements = $_POST['equipements'] ?? [];
        foreach ($equipements as $equipementId) {
            AppRepoManager::getRm()->getAnnoncesRepo()->linkEquipementToAnnonce($annonceId, $equipementId);
        }

        header("Location: /");
    }

    public function delete($id) {
        $annonceRepo = AppRepoManager::getRm()->getAnnoncesRepo();
        
        // Vérifiez d'abord si l'annonce appartient à l'utilisateur actuellement authentifié.
        $annonce = $annonceRepo->findById($id);
        if (!$annonce || $annonce->user_id != Session::get(Session::USER)->id) {
            // Redirigez vers une page d'erreur ou la page d'accueil avec un message d'erreur.
            header('Location: /');
            exit;
        }

        // Supprimez l'annonce.
        $annonceRepo->deleteById($id);

        // Redirigez vers la page d'accueil avec un message de succès.
        header('Location: /?message=Annonce supprimée avec succès.');
        exit;
    }

    public function filterByType() {
        $typeId = (int) $_POST['type_de_logement_id'];
        if ($typeId === 0) {
            $annonces = AppRepoManager::getRm()->getAnnoncesRepo()->findAll();
        } else {
            $annonces = AppRepoManager::getRm()->getAnnoncesRepo()->findByTypeId($typeId);
        }

        // Récupérer les photos pour chaque annonce
        foreach ($annonces as $annonce) {
            $annonce->photo = AppRepoManager::getRm()->getAnnoncesRepo()->findPhotoByAnnonceId($annonce->id);
        }

        // Affichez les annonces filtrées
        $view_data = [
            'annonces' => $annonces,
            'list_title' => 'Annonces filtrées par type'
        ];
        
        $view = new View('pages/home');
        $view->title = 'Annonces filtrées';
        $view->render($view_data);
    }
}
