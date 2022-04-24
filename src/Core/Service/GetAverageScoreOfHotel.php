<?php

namespace App\Core\Service;

use App\Core\Model\AverageScoreResponse;
use App\Core\Model\GetAverageScoreOfHotelRequest;
use App\Core\Model\HotelNotFoundException;
use App\Core\Model\HotelRepositoryInterface;
use App\Core\Model\Review;
use App\Core\Model\ReviewRepositoryInterface;

final class GetAverageScoreOfHotel implements GetAverageScoreOfHotelInterface
{
    public function __construct(
        private readonly HotelRepositoryInterface $hotelRepository,
        private readonly ReviewRepositoryInterface $reviewRepository,
        private readonly GroupReviewsInterface $reviewGrouper
    )
    {
    }

    /**
     * @throws HotelNotFoundException
     */
    public function __invoke(GetAverageScoreOfHotelRequest $request): AverageScoreResponse
    {
        $this->hotelRepository->get($request->hotelId);

        $reviews = $this->reviewRepository->findReviewsByDateRange($request->hotelId, $request->startDate, $request->endDate);

        $rangeInDays = $request->endDate->diff($request->startDate)->d;

        $groupBy = GroupingInterval::month;

        if ($rangeInDays < 30) {
            $groupBy = GroupingInterval::day;
        } else if ($rangeInDays < 90) {
            $groupBy = GroupingInterval::week;
        }

        $groupedReviews = $this->reviewGrouper->by($reviews, $groupBy);

        return new AverageScoreResponse(
            count($reviews),
            $this->averageScore($reviews),
            array_map(function (array $reviews) {
                return $this->averageScore($reviews);
            }, $groupedReviews)
        );
    }

    /**
     * @param Review[] $reviews
     */
    private function averageScore(array $reviews): float
    {
        return array_reduce($reviews, fn(int $a, Review $review) => $a + $review->getScore(), 0) / count($reviews);
    }
}