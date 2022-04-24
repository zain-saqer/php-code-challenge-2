<?php

namespace App\Tests\Controller;

use App\Core\Model\Hotel;
use App\Core\Model\Review;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class OvertimeControllerTest extends WebTestCase
{
    private function initDatabase(KernelInterface $kernel): void
    {
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metaData);
    }
    public function testSomething(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        $this->initDatabase(self::$kernel);

        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        $hotel = new Hotel("");
        $em->persist($hotel);
        $em->flush();
        $em->persist(new Review($hotel->getId(), 1, "", \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2022-04-05 00:00:00")));
        $em->persist(new Review($hotel->getId(), 2, "", \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2022-04-25 00:00:00")));
        $em->flush();

        $client->jsonRequest('GET', '/overtime?hotel-id=1&start-date=2022-04-05 00:00&end-date=2022-04-25 00:00');

        $this->assertResponseIsSuccessful();

        self::assertJsonStringEqualsJsonString('
        {
            "review-count": 2,
            "average-score": 1.5,
            "date-group": "day",
            "scores": [
                1,
                2
            ]
        }
        
        ', $client->getResponse()->getContent());

    }
}
