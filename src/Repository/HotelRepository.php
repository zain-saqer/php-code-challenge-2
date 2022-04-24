<?php

namespace App\Repository;

use App\Core\Model\Hotel;
use App\Core\Model\HotelNotFoundException;
use App\Core\Model\HotelRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class HotelRepository implements HotelRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function get(int $id): Hotel
    {
        $hotel = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(Hotel::class, 'u')
            ->where('u.id = :id')
            ->setParameter("id", $id)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
        if ($hotel === null) {
            throw new HotelNotFoundException();
        }

        return $hotel;
    }
}