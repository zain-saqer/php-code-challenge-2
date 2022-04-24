<?php

namespace App\Tests\Repository;

use App\Core\Model\Review;
use App\Repository\ReviewRepository;
use DateTime;
use DateTimeImmutable;

class ReviewRepositoryTest extends DatabaseTestCase
{

    private function insertData(): void
    {
        $reviews = [
            new Review(123, 123, "", DateTime::createFromFormat("Y-m-d H:i:s:v", "2022-04-01 00:00:00:00")),
            new Review(123, 123, "", DateTime::createFromFormat("Y-m-d H:i:s:v", "2022-04-02 00:00:00:00")),
            new Review(123, 123, "", DateTime::createFromFormat("Y-m-d H:i:s:v", "2022-04-03 00:00:00:00")),
            new Review(1, 123, "", DateTime::createFromFormat("Y-m-d H:i:s:v", "2022-04-01 00:00:00:00")),
        ];

        foreach ($reviews as $review) {
            $this->entityManager->persist($review);
            $this->entityManager->flush();
        }
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_findReviewsByDateRange($hotelId, DateTimeImmutable $s, DateTimeImmutable $e, int $expectedCount): void
    {
        $this->insertData();

        $repo = new ReviewRepository($this->entityManager);

        $result = $repo->findReviewsByDateRange($hotelId, $s, $e);

        self::assertCount($expectedCount, $result);
    }

    public function dataProvider(): array
    {
        return [
            [
                2,
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s:v", "2022-03-01 00:00:00:00"),
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s:v", "2022-05-01 00:00:00:00"),
                0
            ],
            [
                123,
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s:v", "2022-03-01 00:00:00:00"),
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s:v", "2022-05-01 00:00:00:00"),
                3
            ],
            [
                123,
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s:v", "2022-04-01 00:00:00:00"),
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s:v", "2022-04-03 00:00:00:00"),
                3
            ],
            [
                123,
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s:v", "2022-04-01 00:00:00:00"),
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s:v", "2022-04-02 00:00:00:00"),
                2
            ],
        ];
    }
}
