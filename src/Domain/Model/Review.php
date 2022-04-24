<?php

namespace App\Domain\Model;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: Types::INTEGER)]
    private string $hotelId;

    #[ORM\Column(type: Types::INTEGER)]
    private string $score;

    #[ORM\Column(type: Types::STRING, length: 500)]
    private string $comment;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface $createdDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHotelId(): string
    {
        return $this->hotelId;
    }

    /**
     * @param string $hotelId
     */
    public function setHotelId(string $hotelId): void
    {
        $this->hotelId = $hotelId;
    }

    /**
     * @return string
     */
    public function getScore(): string
    {
        return $this->score;
    }

    /**
     * @param string $score
     */
    public function setScore(string $score): void
    {
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getCreatedDate(): DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(DateTimeInterface $createdDate): void
    {
        $this->createdDate = $createdDate;
    }
}
