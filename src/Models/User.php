<?php
namespace App\Models;

class User extends BaseModel {
    public function findByUsernameOrEmail(string $login): ?array {
        $st = $this->db->prepare('SELECT * FROM users WHERE username=:l OR email=:l LIMIT 1');
        $st->execute(['l'=>$login]);
        $row = $st->fetch();
        return $row ?: null;
    }
    public function create(string $username, string $email, string $password): int {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $st = $this->db->prepare('INSERT INTO users (username,email,password_hash) VALUES (:u,:e,:p)');
        $st->execute(['u'=>$username,'e'=>$email,'p'=>$hash]);
        return (int)$this->db->lastInsertId();
    }
}
