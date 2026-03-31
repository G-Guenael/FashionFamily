<?php
require_once __DIR__ . '/../../core/Database.php';

class Article
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM articles ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getLatest(int $limit): array
    {
        $stmt = $this->db->prepare("SELECT * FROM articles ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getRandom(int $limit): array
    {
        $stmt = $this->db->prepare("SELECT * FROM articles ORDER BY RAND() LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT articles.*, users.name AS seller_name
            FROM articles
            JOIN users ON articles.user_id = users.id
            WHERE articles.id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE articles
            SET title = ?, description = ?, price = ?, quantity = ?, article_condition = ?, status = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['price'],
            $data['quantity'],
            $data['article_condition'],
            $data['status'],
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    }

    public function countByMonth(): array
    {
        $stmt = $this->db->prepare("
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
            FROM articles
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY month
            ORDER BY month ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
