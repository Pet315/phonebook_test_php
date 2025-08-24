<?php
namespace App\Models;

class Contact extends BaseModel {
    public function allByUser(int $userId): array {
        $st = $this->db->prepare('SELECT * FROM contacts WHERE user_id=:uid ORDER BY last_name, first_name');
        $st->execute(['uid'=>$userId]);
        return $st->fetchAll();
    }
    public function find(int $id, int $userId): ?array {
        $st = $this->db->prepare('SELECT * FROM contacts WHERE id=:id AND user_id=:uid');
        $st->execute(['id'=>$id,'uid'=>$userId]);
        $row = $st->fetch();
        return $row ?: null;
    }
    public function create(array $data): int {
        $st = $this->db->prepare('INSERT INTO contacts (user_id,first_name,last_name,phone,email,image_path) VALUES (:uid,:fn,:ln,:ph,:em,:img)');
        $st->execute([
            'uid'=>$data['user_id'],
            'fn'=>$data['first_name'],
            'ln'=>$data['last_name'],
            'ph'=>$data['phone'],
            'em'=>$data['email'] ?? null,
            'img'=>$data['image_path'] ?? null
        ]);
        return (int)$this->db->lastInsertId();
    }
    public function update(int $id, int $userId, array $data): bool {
        $st = $this->db->prepare('UPDATE contacts SET first_name=:fn,last_name=:ln,phone=:ph,email=:em,image_path=:img WHERE id=:id AND user_id=:uid');
        return $st->execute([
            'fn'=>$data['first_name'],
            'ln'=>$data['last_name'],
            'ph'=>$data['phone'],
            'em'=>$data['email'] ?? null,
            'img'=>$data['image_path'] ?? null,
            'id'=>$id,
            'uid'=>$userId
        ]);
    }
    public function delete(int $id, int $userId): bool {
        $st = $this->db->prepare('DELETE FROM contacts WHERE id=:id AND user_id=:uid');
        return $st->execute(['id'=>$id,'uid'=>$userId]);
    }
}
