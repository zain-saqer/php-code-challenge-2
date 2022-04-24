<?php

namespace App\Tests\Core\Service;

use App\Core\Model\AverageScoreResponse;
use App\Core\Model\GetAverageScoreOfHotelRequest;
use App\Core\Model\Hotel;
use App\Core\Model\HotelRepositoryInterface;
use App\Core\Model\Review;
use App\Core\Model\ReviewRepositoryInterface;
use App\Core\Service\GetAverageScoreOfHotel;
use App\Core\Service\GroupReviewsInterface;
use App\Core\Service\GroupingInterval;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class GetAverageScoreOfHotelTest extends TestCase
{
    public function test_GetAverageScoreOfHotel(): void
    {
        $hotelId = 123;
        $rangeStart = DateTimeImmutable::createFromFormat("U", 1);
        $rangeEnd = DateTimeImmutable::createFromFormat("U", 2);
        $hotel = new Hotel("name");
        $reviews = [
            new Review($hotelId, 1, "", new DateTimeImmutable()),
            new Review($hotelId, 1, "", new DateTimeImmutable()),
        ];
        $groupedReviews = [
            [new Review($hotelId, 1, "", new DateTimeImmutable()),
                new Review($hotelId, 1, "", new DateTimeImmutable()),
            ],
        ];
        $hotelRepo = $this->createMock(HotelRepositoryInterface::class);
        $hotelRepo->method('get')
            ->willReturn($hotel);
        $reviewRepo = $this->createMock(ReviewRepositoryInterface::class);
        $reviewRepo->method('findReviewsByDateRange')
            ->willReturnCallback(function (int $id, DateTimeImmutable $startDate, DateTimeImmutable $endDate) use ($hotelId, $rangeStart, $rangeEnd, $reviews) {
                self::assertEquals($hotelId, $id);
                self::assertEquals($rangeStart, $startDate);
                self::assertEquals($rangeEnd, $endDate);

                return $reviews;
            });

        $groupReviews = $this->createMock(GroupReviewsInterface::class);
        $groupReviews->method('by')
            ->willReturnCallback(function (array $reviews, GroupingInterval $interval) use ($groupedReviews) {
                self::assertSame(GroupingInterval::day, $interval);

                return $groupedReviews;
            });

        $getAverageScoreOfHotel = new GetAverageScoreOfHotel(
            $hotelRepo,
            $reviewRepo,
            $groupReviews
        );

        $response = $getAverageScoreOfHotel(new GetAverageScoreOfHotelRequest($hotelId, $rangeStart, $rangeEnd));

        self::assertSame(1.0, $response->averageScore);
        self::assertSame(2, $response->count);
        self::assertEquals([1.0], $response->scores);
    }
}
