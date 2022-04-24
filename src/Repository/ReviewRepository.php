<?php

namespace App\Repository;

use App\Core\Model\Review;
use App\Core\Model\ReviewRepositoryInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return Review[]
     */
    public function findReviewsByDateRange(int $hotelId, DateTimeImmutable $startDate, DateTimeImmutable $endDate): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('r')
            ->from(Review::class, 'r')
            ->andWhere('r.hotelId = :id')
            ->andWhere("r.createdDate  BETWEEN :s AND :e ")
            ->setParameter("id", $hotelId)
            ->setParameter('s', $startDate->format("Y-m-d"))
            ->setParameter('e', $endDate->format("Y-m-d"))
            ->orderBy('r.createdDate')
            ->getQuery()
            ->getArrayResult();
    }
}