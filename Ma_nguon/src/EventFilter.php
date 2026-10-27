<?php
declare(strict_types=1);

function filterEvents(
    array $events,
    string $query,
    string $category = '',
    bool $availableOnly = false
): array {
    $result = [];

    foreach ($events as $event) {
        // Điều kiện 1: từ khóa
        $matchesQuery = $query === ''
            || stripos($event['title'], $query) !== false;

        // Điều kiện 2: loại sự kiện
        $matchesCategory = $category === ''
            || $event['category'] === $category;

        // Điều kiện 3: chỉ lấy sự kiện còn chỗ
        $matchesAvailable = !$availableOnly
            || $event['registered'] < $event['capacity'];

        // Cả 3 điều kiện đều phải đúng
        if ($matchesQuery && $matchesCategory && $matchesAvailable) {
            $result[] = $event;
        }
    }

    return $result;
}