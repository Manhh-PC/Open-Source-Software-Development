<?php
declare(strict_types=1);

function canComplete(
    array $session,
    int $eventId,
    int $now,
    int $ttl
): bool {
    // TTL phải lớn hơn 0
    if ($ttl <= 0) {
        return false;
    }

    // Phải tồn tại draft
    if (!isset($session['draft']) || !is_array($session['draft'])) {
        return false;
    }

    $draft = $session['draft'];

    // Draft phải có data
    if (!isset($draft['data']) || !is_array($draft['data'])) {
        return false;
    }

    // Phải có event_id và created_at
    if (
        !array_key_exists('event_id', $draft['data']) ||
        !array_key_exists('created_at', $draft)
    ) {
        return false;
    }

    // Giá trị phải có thể chuyển thành số
    if (
        !is_numeric($draft['data']['event_id']) ||
        !is_numeric($draft['created_at'])
    ) {
        return false;
    }

    $draftEventId = (int)$draft['data']['event_id'];
    $createdAt = (int)$draft['created_at'];

    // Draft phải đúng sự kiện đang xác nhận
    if ($draftEventId !== $eventId) {
        return false;
    }

    // Không chấp nhận thời điểm tạo nằm trong tương lai
    if ($createdAt > $now) {
        return false;
    }

    // Tuổi draft phải NHỎ HƠN TTL
    $age = $now - $createdAt;

    if ($age >= $ttl) {
        return false;
    }

    return true;
}