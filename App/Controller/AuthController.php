<?php

namespace App\Controller;

use App\Model\User;
use Core\View\View;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;
use Laminas\Diactoros\ServerRequest;

class AuthController extends Controller {

    public function login() {
        $view = new View('auth/login', false);

        $form_result = Session::get(Session::FORM_RESULT);

        // Réinitialisez la session FORM_RESULT après l'avoir récupérée.
        Session::remove(Session::FORM_RESULT);

        $view_data = [
            'form_result' => $form_result
        ];

        $view->render($view_data);
    }

    public function loginPost(ServerRequest $request) {
        $post_data = $request->getParsedBody();
        $form_result = new FormResult();

        if (empty($post_data['email']) || empty($post_data['password'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
        } else {
            $email = $post_data['email'];
            $password = $post_data['password'];

            $user = AppRepoManager::getRm()->getUserRepo()->checkAuth($email, $password);

            if (is_null($user)) {
                $form_result->addError(new FormError('Email ou mot de passe incorrect'));
            }
        }

        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/connexion');
        }

        $user->password = '';
        Session::set(Session::USER, $user);
        self::redirect('/');
    }

    public static function isAuth(): bool {
        return !is_null(Session::get(Session::USER));
    }

    private static function hasRole(int $is_hote): bool {
        $user = Session::get(Session::USER);

        if (!($user instanceof User)) {
            return false;
        }

        if ($is_hote === User::ROLE_HOTE) {
            return $user->is_hote === true;
        } elseif ($is_hote === User::ROLE_STANDARD) {
            return $user->is_hote === false;
        }

        return false; // Par défaut, retourner false
    }

    // Méthode de déconnexion
    public function logout() {
        // On détruit la session
        Session::remove(Session::USER);
        self::redirect('/');
    }

    public static function isStandard(): bool {
        return self::hasRole(User::ROLE_STANDARD);
    }

    public static function isHote(): bool {
        return self::hasRole(User::ROLE_HOTE);
    }

    public function signup() {
        $view = new View('auth/signup');  
        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        $view->render($view_data);
    }

    public function signupPost(ServerRequest $request) {
        $post_data = $request->getParsedBody();

        $email = $post_data['email'];
        $password = $post_data['password'];
        $is_hote = isset($post_data['is_hote']) ? 1 : 0;
        $nom = $post_data['nom'];
        $prenom = $post_data['prenom'];

        $created = AppRepoManager::getRm()->getUserRepo()->createUser($email, $password, $is_hote, $nom, $prenom);

        if ($created) {
            self::redirect('/connexion');
        } else {
            Session::set(Session::FORM_RESULT, new FormResult("L'email est déjà utilisé ou une autre erreur s'est produite."));
            self::redirect('/inscription');
        }
    }

    public function switchRole() {
        $user = Session::get(Session::USER);

        if (!($user instanceof User)) {
            self::redirect('/');
            return;
        }

        // Switch the role
        $user->is_hote = !$user->is_hote;

        // Update the base de données
        $updated = AppRepoManager::getRm()->getUserRepo()->updateUserRole($user->id, $user->is_hote);

        if (!$updated) {
            Session::set(Session::FORM_RESULT, new FormResult("erreur"));
            self::redirect('/');
            return;
        }

        Session::set(Session::USER, $user);

        // Redirection vers page d'accueil
        self::redirect('/');
    }
}
