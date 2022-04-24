<?php

namespace App\Core\Model;

class AverageScoreResponse
{
    public function __construct(
        
        public int $count,
        public float $averageScore,
        public array $averageScoreGroups)
    {
    }
}