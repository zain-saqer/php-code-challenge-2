<?php

namespace App\Core\Service;

use App\Core\Model\Review;
use DateInterval;
use Exception;

class GroupReviews implements GroupReviewsInterface
{

    /**
     * @param Review[] $reviews
     * @param GroupingInterval $interval
     * @return Review[]
     * @throws Exception
     */
    public function by(array $reviews, GroupingInterval $interval): array
    {
        if (count($reviews) === 0 ) {
            return [];
        }

        usort($reviews, function(Review $a, Review $b) {
            return $a->getCreatedDate()->getTimestamp() - $b->getCreatedDate()->getTimestamp();
        });

        $groups = [];
        $intervalAsString = match ($interval) {
            GroupingInterval::day => "P1D",
            GroupingInterval::month => "P1M",
            GroupingInterval::week => "P7D",
        };

        $modifier = match ($interval) {
            GroupingInterval::day, GroupingInterval::month => "first day of this month",
            GroupingInterval::week => "Monday this week",
        };

        $i = 0;
        $endDate = \DateTime::createFromInterface($reviews[$i]->getCreatedDate())
            ->modify($modifier);
        while ($i < count($reviews)) {
            $group = [];

            $endDate
                ->add(new DateInterval($intervalAsString));

            while($i < count($reviews)) {
                $review = $reviews[$i];
                if ($review->getCreatedDate()->getTimestamp() < $endDate->getTimestamp()) {
                    $group[] = $review;
                } else {
                    break;
                }
                $i++;
            }
            if (count($group) > 0) {
                $groups[] = $group;
            }
        }

        return $groups;
    }


}