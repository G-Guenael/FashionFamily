<?php
require_once __DIR__ . '/../../core/Database.php';

class Article
{
    private PDO $db;

    // Slug → label (utilisé partout : header, vues, filtres)
    public const CATEGORIES = [
        'vetements'    => 'Vêtements',
        'chaussures'   => 'Chaussures',
        'accessoires'  => 'Accessoires',
        'electronique' => 'Électronique',
        'informatique' => 'Informatique',
        'mobilier'     => 'Mobilier',
        'maison'       => 'Maison',
        'sport'        => 'Sport',
        'jeux-video'   => 'Jeux vidéo',
        'sacs'         => 'Sacs',
        'bijoux'       => 'Bijoux',
        'sous-vetements' => 'Sous-vêtements',
        'autre'        => 'Autre',
    ];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Retourne le label d'une catégorie depuis son slug.
     * Gère aussi les anciens articles où le label était stocké directement.
     */
    public static function categoryLabel(string $slug): string
    {
        return self::CATEGORIES[$slug] ?? ucfirst($slug);
    }

    public function getAll(string $sort = 'newest'): array
    {
        $order = match($sort) {
            'price_asc'  => 'price ASC',
            'price_desc' => 'price DESC',
            'oldest'     => 'created_at ASC',
            default      => 'created_at DESC', // newest
        };
        $stmt = $this->db->query("SELECT * FROM articles ORDER BY $order");
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

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO articles (user_id, title, description, image_path, price, currency, quantity, category, article_condition, status)
            VALUES (?, ?, ?, ?, ?, 'EUR', ?, ?, ?, 'active')
        ");
        $stmt->execute([
            $data['user_id'],
            $data['title'],
            $data['description'],
            $data['image_path'],
            $data['price'],
            $data['quantity'],
            $data['category'],
            $data['article_condition'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
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

    public function getTopByPrice(int $limit): array
    {
        $stmt = $this->db->prepare("SELECT * FROM articles ORDER BY price DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Retourne les articles d'une catégorie.
     * Gère les deux formats stockés en DB : slug ('vetements') ou label ('Vêtements').
     */
    public function getByCategory(string $slug): array
    {
        $label = self::CATEGORIES[$slug] ?? $slug;

        $stmt = $this->db->prepare("
            SELECT articles.*, users.name AS seller_name
            FROM articles
            JOIN users ON articles.user_id = users.id
            WHERE articles.category = ? OR articles.category = ?
            ORDER BY articles.created_at DESC
        ");
        $stmt->execute([$slug, $label]);
        return $stmt->fetchAll();
    }

    public function search(string $query): array
    {
        $stmt = $this->db->prepare("
            SELECT articles.*, users.name AS seller_name
            FROM articles
            JOIN users ON articles.user_id = users.id
            WHERE articles.title LIKE ? OR articles.description LIKE ? OR articles.category LIKE ?
            ORDER BY articles.created_at DESC
        ");
        $like = "%$query%";
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll();
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
