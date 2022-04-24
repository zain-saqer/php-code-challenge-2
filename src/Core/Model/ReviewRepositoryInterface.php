<?php

namespace App\Core\Model;

use DateTimeImmutable;

interface ReviewRepositoryInterface
{
    /**
     * @return Review[]
     */
    public function findReviewsByDateRange(int $hotelId, DateTimeImmutable $startDate, DateTimeImmutable $endDate): array;
}