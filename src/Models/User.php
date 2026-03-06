<?php
namespace App\Models;
use PDO;

class User{

private PDO $db;

    public function __construct(PDO $db) {  
        $this->db = $db;
    }

    public function getUsers(): array{
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById(int $userId): array{
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByName(string $userName): array{
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$userName]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser(array $data):string|false{
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password)
        VALUES ( ?, ?, ?) ");
        $password = password_hash($data['userPass'], PASSWORD_DEFAULT);
        $stmt->execute([
            $data['userName'],
            $data['userEmail'],
            $password 
        ]);
        return $this->db->lastInsertId();

    }

    public function updateUser(int $userId, array $data): bool{
        $setParts = [];
        $values = [];
        foreach ($data as $field => $value) {
            $setParts[] = "$field = ?";
            $values[] = $value;
        }
        $values[] = $userId;
        $sql = "UPDATE users SET " . implode(', ', $setParts) . " 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function deleteUser(int $userId): bool{
      $stmt = $this->db->prepare("DELETE FROM users WHERE id = ? ");
        return $stmt->execute([$userId]);
    }
    





}