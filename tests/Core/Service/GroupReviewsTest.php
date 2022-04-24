<?php

namespace App\Tests\Core\Service;

use App\Core\Model\Review;
use App\Core\Service\GroupingInterval;
use App\Core\Service\GroupReviews;
use PHPUnit\Framework\TestCase;

class GroupReviewsTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test_by(array $reviews, GroupingInterval $interval, array $expected): void
    {
        $groupReviews = new GroupReviews();

        self::assertEquals($expected, $groupReviews->by($reviews, $interval));
    }

    public function dataProvider(): array
    {
        return [
            [
                [
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-26 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-26 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                ],
                GroupingInterval::day,
                [
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                    ],
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-26 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-26 00:00:00")),
                    ],
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-29 00:00:00")),
                    ]
                ]
            ],
            [
                [
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-01 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-02 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-03 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-04 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-05 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-11 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-12 00:00:00")),
                ],
                GroupingInterval::week,
                [
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-01 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-02 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-03 00:00:00")),
                    ],
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-04 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-05 00:00:00")),
                    ],
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-11 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-12 00:00:00")),
                    ]
                ]
            ],
            [
                [
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-05-26 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-05-26 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                    new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                ],
                GroupingInterval::month,
                [
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-04-24 00:00:00")),
                    ],
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-05-26 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-05-26 00:00:00")),
                    ],
                    [
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                        new Review(123, 123, "", \DateTime::createFromFormat("Y-m-d H:i:s", "2022-06-29 00:00:00")),
                    ]
                ]
            ],
        ];
    }
}
