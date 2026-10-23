<?php
declare(strict_types=1);
final class RegistrationPolicy
{
    public function decide(
        int $capacity,
        int $registered,
        bool $open,
        bool $waitingEnabled
    ): string {
        // 1. Dữ liệu không hợp lệ
        if ($capacity <= 0 || $registered < 0 || $registered > $capacity) {
            return 'rejected';
        }

        // 2. Sự kiện đã đóng
        if (!$open) {
            return 'rejected';
        }

        // 3. Sự kiện còn chỗ
        if ($registered < $capacity) {
            return 'confirmed';
        }

        // 4. Hết chỗ nhưng có danh sách chờ
        if ($waitingEnabled) {
            return 'waiting';
        }

        // 5. Hết chỗ và không có danh sách chờ
        return 'rejected';
    }
}