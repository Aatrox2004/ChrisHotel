<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';

class LoginController {
    public function Index() {
        $data = ['page_title' => 'Login'];
        render(__DIR__ . '/../Views/User/Login.php', $data);
    }

    public function Process() {
        $action = $_POST['action'] ?? '';

        if ($action === 'login') {
            header('Location: ' . BASE_URL . 'index.php?url=Login/ValidateLogin');
        } elseif ($action === 'register') {
            header('Location: ' . BASE_URL . 'index.php?url=Login/ValidateRegister');
        }
        exit;
    }

    public function ValidateLogin() {
        // Example: validate login form
        $_SESSION['user_id'] = uniqid("USER"); 
        header('Location: ' . BASE_URL . 'index.php?url=UserProfile');
        exit;
    }

    public function ValidateRegister() {
        // Example: validate register form
        $_SESSION['user_id'] = uniqid("USER"); 
        header('Location: ' . BASE_URL . 'index.php?url=UserProfile');
        exit;
    }
}
