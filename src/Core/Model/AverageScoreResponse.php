<?php

namespace App\Core\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class AverageScoreResponse
{
    public function __construct(
        #[SerializedName('review-count')]
        public readonly int $count,
        #[SerializedName('average-score')]
        public readonly float $averageScore,
        #[SerializedName('date-group')]
        public readonly string $dateGroup,
        #[SerializedName('scores')]
        public readonly array $scores)
    {
    }
}