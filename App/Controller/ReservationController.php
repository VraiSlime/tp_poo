<?php

namespace App\Controller;

use Core\View\View;
use Core\Session\Session;
use Core\Repository\AppRepoManager;
use App\Model\Repository\ReservationRepository;

class ReservationController {
    private $reservationRepository;

    public function __construct() {
        $this->reservationRepository = (new AppRepoManager())->getReservationRepository();
    }
    
    public function reserve() {
        if (!isset($_SESSION['USER'])) {
            header('Location: /login');
            exit();
        }

        $dateDebut = $_POST['date_debut'];
        $dateFin = $_POST['date_fin'];
        $annonceId = $_POST['annonce_id'];
        $nbrDePersonne = isset($_POST['nbr_de_personne']) ? $_POST['nbr_de_personne'] : null;

        if ($this->isDatesValid($dateDebut, $dateFin)) {
            $reservationId = $this->reservationRepository->createReservation($annonceId, $dateDebut, $dateFin, $nbrDePersonne);
            
            header('Location: /reservations/list');
            exit();

            $view_data = [
                'title_tag' => 'Confirmation de réservation',
                'message' => 'Votre réservation a été confirmée.',
                'reservationId' => $reservationId
            ];

            $view = new View('pages/confirmation');
            $view->title = 'Confirmation de réservation';
            $view->render($view_data);
        } else {
            $view_data = [
                'title_tag' => 'Erreur de réservation',
                'error_message' => 'Les dates de réservation ne sont pas valides.'
            ];

            $view = new View('pages/error');
            $view->title = 'Erreur de réservation';
            $view->render($view_data);
        }
    }

    private function isDatesValid($dateDebut, $dateFin) {
        // TODO: Ajoutez la logique de validation 
        return true;
    }

    public function showReservations() {
        $reservations = AppRepoManager::getRm()->getReservationRepository()->findReservationsByUserId($_SESSION['USER']->id);

        $view = new View('pages/reservations');
        $view->title = 'Mes Réservations';
        $view->render(['reservations' => $reservations]);
    }

    public function showHostReservations() {
        // Vérifiez si l'utilisateur est connecté et est un hôte
        if (!isset($_SESSION['USER']) || !$_SESSION['USER']->is_hote) {
            header('Location: /login');
            exit();
        }
        
        $reservations = $this->reservationRepository->getReservationsForHost($_SESSION['USER']->id);
        
        $view = new View('pages/host_reservations');
        $view->title = 'Réservations de mes Annonces';
        $view->render(['reservations' => $reservations]);
    }
}
