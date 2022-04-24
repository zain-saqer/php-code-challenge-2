<?php

namespace App\Core\Service;

use App\Core\Model\Review;

interface GroupReviewsInterface
{
    /**
     * @param Review[] $reviews
     * @return Review[]
     */
    public function by(array $reviews, GroupingInterval $interval): array;
}