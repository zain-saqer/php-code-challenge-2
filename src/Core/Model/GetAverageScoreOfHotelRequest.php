<?php

namespace App\Core\Model;

use DateTimeImmutable;

class GetAverageScoreOfHotelRequest
{
    public function __construct(
        public readonly int $hotelId,
        public readonly DateTimeImmutable $startDate,
        public readonly DateTimeImmutable $endDate
    )
    {
    }
}