<?php
class Cart
{
    private static string $sessionKey = 'cart';

    public static function getItems(): array
    {
        return $_SESSION[self::$sessionKey] ?? [];
    }

    public static function add(array $article, int $quantity = 1): void
    {
        $id = (int) $article['id'];
        $maxQty = (int) $article['quantity'];
        $cart = self::getItems();

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + $quantity;
            $cart[$id]['quantity'] = min($newQty, $maxQty);
        } else {
            $cart[$id] = [
                'id'           => $id,
                'title'        => $article['title'],
                'price'        => (float) $article['price'],
                'image_path'   => $article['image_path'],
                'quantity'     => min($quantity, $maxQty),
                'max_quantity' => $maxQty,
            ];
        }

        $_SESSION[self::$sessionKey] = $cart;
    }

    public static function update(int $articleId, int $quantity): void
    {
        $cart = self::getItems();

        if (!isset($cart[$articleId])) {
            return;
        }

        if ($quantity <= 0) {
            self::remove($articleId);
            return;
        }

        $cart[$articleId]['quantity'] = min($quantity, $cart[$articleId]['max_quantity']);
        $_SESSION[self::$sessionKey] = $cart;
    }

    public static function remove(int $articleId): void
    {
        $cart = self::getItems();
        unset($cart[$articleId]);
        $_SESSION[self::$sessionKey] = $cart;
    }

    public static function clear(): void
    {
        $_SESSION[self::$sessionKey] = [];
    }

    public static function getTotal(): float
    {
        $total = 0.0;
        foreach (self::getItems() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public static function getCount(): int
    {
        $count = 0;
        foreach (self::getItems() as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public static function isEmpty(): bool
    {
        return empty(self::getItems());
    }

    public static function has(int $articleId): bool
    {
        return isset(self::getItems()[$articleId]);
    }
}
