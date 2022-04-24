<?php

namespace App\Core\Model;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::INTEGER)]
    private int $hotelId;

    #[ORM\Column(type: Types::INTEGER)]
    private int $score;

    #[ORM\Column(type: Types::STRING, length: 500)]
    private string $comment;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface $createdDate;

    public function __construct(int $hotelId, int $score, string $comment, DateTimeInterface $createdDate)
    {
        $this->hotelId = $hotelId;
        $this->comment = $comment;
        $this->createdDate = $createdDate;
        $this->score = $score;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHotelId(): int
    {
        return $this->hotelId;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedDate(): DateTimeInterface
    {
        return $this->createdDate;
    }
}
