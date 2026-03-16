<?php
namespace App\Models;
use PDO;

class Task {
    private PDO $db;

    public function __construct(PDO $db) {  
        $this->db = $db;
    }

    public function getTasks(): array {  
        $stmt = $this->db->prepare("SELECT * FROM tasks ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTasksByUser(int $userId): array {  
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }

    public function getTaskByTitleAndUser(string $title, int $userId): ?array { 
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE title = ? AND user_id = ?");
        $stmt->execute([$title, $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getTasksByCategory(string $categoryName, int $userId): array { 
        $stmt = $this->db->prepare("
            SELECT t.*, c.name as category_name 
            FROM tasks t
            JOIN categories c ON t.category_id = c.id
            WHERE c.name = ? AND t.user_id = ?
            ORDER BY t.created_at DESC");
        $stmt->execute([$categoryName, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }
    
    public function getTaskById(int $taskId, int $userId): ?array {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$taskId, $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getCategoryTask(int $taskId, int $userId): ?array {
        $stmt = $this->db->prepare("SELECT category_id FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$taskId, $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    

    public function createTask(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO tasks 
                (user_id, title, description, status, priority, category_id, start_date, due_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['user_id'],
            $data['title'],
            $data['description'] ?? null,
            $data['status'] ?? 'pending',
            $data['priority'] ?? 'medium',
            $data['category_id'] ?? null,
            $data['start_date'] ?? null,
            $data['due_date'] ?? null
        ]);
    }

   public function updateTask(int $taskId, int $userId, array $data): bool {
        $setParts = [];
        $values = [];
        foreach ($data as $field => $value) {
            $setParts[] = "$field = ?";
            $values[] = $value;
        }
        if (empty($setParts)) {
            return false;
        }
        $values[] = $taskId;
        $values[] = $userId;
        $sql = "UPDATE tasks SET " . implode(', ', $setParts) . " 
                WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function deleteTask(int $userID,int $taskId ): bool {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE user_id = ? AND id = ? ");
        return $stmt->execute([$userID, $taskId]);
    }

}