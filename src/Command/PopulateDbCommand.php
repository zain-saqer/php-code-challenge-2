<?php

namespace App\Command;


use App\Core\Model\Hotel;
use App\Core\Model\Review;
use DateInterval;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDbCommand extends Command
{
    protected static $defaultName = 'app:populate-db';

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        for ($i = 0; $i < 10; $i++) {
            $hotel = new Hotel("name " . $i);
            $this->entityManager->persist($hotel);
            $this->entityManager->flush();
            for($j = 0; $j < 10000; $j++) {
                $this->entityManager->persist(new Review(
                    $hotel->getId(),
                    rand(0, 5),
                    "comment",
                    (new DateTimeImmutable())->sub(new DateInterval(sprintf("P%dD", rand(0, 720))))
                ));
            }
            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }
}