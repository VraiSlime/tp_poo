<?php

namespace Core;

use App\Controller\ToyController;
use MiladRahimi\PhpRouter\Router;
use App\Controller\AuthController;
use App\Controller\HomeController;
use App\Controller\AdminController;
use App\Controller\AnnoncesController;
use App\Controller\ReservationController;
use Core\Database\DatabaseConfigInterface;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Exceptions\InvalidCallableException;

class App implements DatabaseConfigInterface
{
    private const DB_HOST = 'database';
    private const DB_NAME = 'airbnb';
    private const DB_USER = 'admin';
    private const DB_PASS = 'admin';

    private static ?self $instance = null;
    private Router $router;

    public static function getApp(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    private function __construct()
    {
        $this->router = Router::create();
    }

    public function start(): void
    {
        session_start();
        $this->registerRoutes();
        $this->startRouter();
    }

    private function registerRoutes(): void
    {
        $this->router->pattern('id', '[0-9]\d*');
        $this->router->pattern('slug', '(\d+-)?[a-z]+(-[a-z\d]+)*');
        $this->router->get('/', [HomeController::class, 'index']);
        $this->router->get('/annonce/{id}/detail', [AnnoncesController::class, 'showDetail']);
        $this->router->get('/inscription', [AuthController::class, 'signup']);
        $this->router->post('/inscription', [AuthController::class, 'signupPost']);
        $this->router->get('/connexion', [AuthController::class, 'login']);
        $this->router->post('/login', [AuthController::class, 'loginPost']);
        $this->router->get('/logout', [AuthController::class, 'logout']);
        $this->router->get('/annonces/add', [AnnoncesController::class, 'showAddForm']);
        $this->router->get('/annonce/{id}/delete', [AnnoncesController::class, 'delete']);
        $this->router->post('/annonces/store', [AnnoncesController::class, 'store']);
        $this->router->post('/reservations/create', [ReservationController::class, 'reserve']);
        $this->router->get('/reservations/list', [ReservationController::class, 'showReservations']);
        $this->router->get('/host/reservations', [ReservationController::class, 'showHostReservations']);
        $this->router->get('/switch-role', [AuthController::class, 'switchRole']);
        $this->router->post('/', [AnnoncesController::class, 'filterByType']);
    }

    private function startRouter(): void
    {
        try {
            $this->router->dispatch();
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        } catch (InvalidCallableException $e) {
            echo $e->getMessage();
        }
    }

    public function getHost(): string
    {
        return self::DB_HOST;
    }

    public function getName(): string
    {
        return self::DB_NAME;
    }

    public function getUser(): string
    {
        return self::DB_USER;
    }

    public function getPass(): string
    {
        return self::DB_PASS;
    }
}
