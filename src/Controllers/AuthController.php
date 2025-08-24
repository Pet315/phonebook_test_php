<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\User;
use App\Validation\Validator;

class AuthController extends Controller
{
    public function login(): void
    {
        if (!empty($_SESSION['user_id'])) { header('Location: /contacts'); exit; }
        $this->view('auth/login', ['csrf'=>Csrf::token()]);
    }

    public function doLogin(): void
    {
        if (!Csrf::check($_POST['csrf'] ?? null)){
            $this->view('auth/login', ['error'=>'Invalid CSRF token', 'csrf'=>Csrf::token()]); return;
        }
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = (new User($this->config))->findByUsernameOrEmail($login);
        if (!$user || !password_verify($password, $user['password_hash'])){
            $this->view('auth/login', ['error'=>'Невірний логін або пароль', 'csrf'=>Csrf::token()]); return;
        }
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: /contacts');
    }

    public function register(): void
    {
        if (!empty($_SESSION['user_id'])) { header('Location: /contacts'); exit; }
        $this->view('auth/register', ['csrf'=>Csrf::token()]);
    }

    public function doRegister(): void
    {
        if (!Csrf::check($_POST['csrf'] ?? null)){
            $this->view('auth/register', ['error'=>'Invalid CSRF token', 'csrf'=>Csrf::token()]); return;
        }
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];
        if (!Validator::username($username)) $errors[] = 'Некоректний логін';
        if (!Validator::email($email)) $errors[] = 'Некоректна пошта';
        if (!Validator::password($password)) $errors[] = 'Слабкий пароль';

        if ($errors){
            $this->view('auth/register', ['errors'=>$errors, 'csrf'=>Csrf::token()]);
            return;
        }
        try{
            $userId = (new User($this->config))->create($username,$email,$password);
        } catch (\PDOException $e){
            $msg = 'Користувач або email вже зайняті';
            $this->view('auth/register', ['error'=>$msg, 'csrf'=>Csrf::token()]);
            return;
        }
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        header('Location: /contacts');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
    }
}
