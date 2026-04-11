<?php
require_once __DIR__ . '/../../core/Database.php';

class Order
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(int $buyerId, array $items, float $total): int
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
                INSERT INTO orders (buyer_id, total_price, status) VALUES (?, ?, 'pending')
            ");
            $stmt->execute([$buyerId, $total]);
            $orderId = (int) $this->db->lastInsertId();

            $itemStmt = $this->db->prepare("
                INSERT INTO order_items (order_id, article_id, quantity, price) VALUES (?, ?, ?, ?)
            ");
            foreach ($items as $item) {
                $itemStmt->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT o.*, u.name AS buyer_name, u.email AS buyer_email
            FROM orders o
            JOIN users u ON o.buyer_id = u.id
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function search(string $query): array
    {
        $stmt = $this->db->prepare("
            SELECT o.*, u.name AS buyer_name, u.email AS buyer_email
            FROM orders o
            JOIN users u ON o.buyer_id = u.id
            WHERE u.name LIKE ? OR u.email LIKE ? OR o.status LIKE ?
            ORDER BY o.created_at DESC
        ");
        $like = '%' . $query . '%';
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT o.*, u.name AS buyer_name, u.email AS buyer_email
            FROM orders o
            JOIN users u ON o.buyer_id = u.id
            WHERE o.id = ?
        ");
        $stmt->execute([$id]);
        $order = $stmt->fetch();
        if (!$order) return null;

        $itemStmt = $this->db->prepare("
            SELECT oi.*, a.title, a.image_path
            FROM order_items oi
            JOIN articles a ON oi.article_id = a.id
            WHERE oi.order_id = ?
        ");
        $itemStmt->execute([$id]);
        $order['items'] = $itemStmt->fetchAll();

        return $order;
    }

    public function getByBuyerId(int $buyerId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM orders WHERE buyer_id = ? ORDER BY created_at DESC
        ");
        $stmt->execute([$buyerId]);
        return $stmt->fetchAll();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $allowed = ['pending', 'paid', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($status, $allowed)) return false;

        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    }
}
