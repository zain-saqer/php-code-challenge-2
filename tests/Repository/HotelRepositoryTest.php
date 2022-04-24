<?php

namespace App\Tests\Repository;

use App\Core\Model\Hotel;
use App\Core\Model\HotelNotFoundException;
use App\Repository\HotelRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HotelRepositoryTest extends DatabaseTestCase
{
    public function test_get(): void
    {
        $hotel = new Hotel("name");
        $this->entityManager->persist($hotel);
        $this->entityManager->flush();

        self::assertEquals($hotel, (new HotelRepository($this->entityManager))->get($hotel->getId()));
    }
    public function test_get_throws_exception_when_hotel_not_found(): void
    {
        $this->expectException(HotelNotFoundException::class);
        (new HotelRepository($this->entityManager))->get(321);
    }
}
