<?php
namespace App\Models;
use PDO; 
class category{
 private PDO  $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function getCategories(): array{
        $stmt = $this->db->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById(int $categoryId): array{
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategoryByNAme(string $categoryName): array{
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE name = ?");
        $stmt->execute([$categoryName]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCategory(array $data): bool{
        $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (?)");
        return $stmt->execute([ $data['category_Name'] ]);
    }

    public function deleteCategory(int $categoryId): bool{
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$categoryId]);
       
    }

}