<?php

namespace App\Core\Service;

use App\Core\Model\AverageScoreResponse;
use App\Core\Model\GetAverageScoreOfHotelRequest;

interface GetAverageScoreOfHotelInterface
{
    public function __invoke(GetAverageScoreOfHotelRequest $request): AverageScoreResponse;
}