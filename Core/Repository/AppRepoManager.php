<?php 

namespace Core\Repository;

use Core\App;

use App\Model\Repository\UserRepository;
use App\Model\Repository\AnnoncesRepository;
use App\Model\Repository\ReservationRepository;


class AppRepoManager
{

    //on importe le trait
    use RepositoryManagerTrait;
    private UserRepository $userRepository;
    private AnnoncesRepository $annoncesRepository;
 

    //on crée le getter
    //celui de UserRepository
    public function getUserRepo(): UserRepository
    {
        return $this->userRepository;
    }
    public function getAnnoncesRepo(): AnnoncesRepository
    {
        return $this->annoncesRepository;
    }

    public function getReservationRepository(): ReservationRepository
    {
        return $this->reservationRepository;
    }

    public function __construct()
    {
        $config = App::getApp();   
        $this->userRepository = new UserRepository($config);
        $this->annoncesRepository = new AnnoncesRepository($config);
        $this->reservationRepository = new ReservationRepository($config);
    }
}
