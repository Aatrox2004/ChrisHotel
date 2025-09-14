<?php
require_once __DIR__ . '/../../DBConnect.php';

class UserEntity {
    public $user_id;
    public $username;
    public $email;
    public $phone;
    public $role;
    public $created_at;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function getUser(int $userId): ?array {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT user_id, username, email, phone, role, created_at FROM users WHERE user_id = :user_id");
            $stmt->execute([':user_id' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        } catch (Exception $e) {
            error_log('getUser error: ' . $e->getMessage());
            return null;
        }
    }

    public static function getAllUsers(): array {
        try {
            $db = Database::getInstance();
            $stmt = $db->query("SELECT user_id, username, email, phone, role, created_at FROM users WHERE role = 'guest'");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('getAllUsers error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getUserByName(string $username): ?array {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT user_id, username, email, phone, role, created_at FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        } catch (Exception $e) {
            error_log('getUserByName error: ' . $e->getMessage());
            return null;
        }
    }

    public static function getAdmin(): array {
        try {
            $db = Database::getInstance();
            $stmt = $db->query("SELECT * FROM users WHERE role = 'admin'");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('getAdmins error: ' . $e->getMessage());
            return [];
        }
    }
}
