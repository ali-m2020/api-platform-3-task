<?php

namespace App\Entity;

use Assert\Positive;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReviewRepository;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource(
    shortName: 'MyReview',
    description: 'Car Review Entity - as part of Devish Task done by Ali Mirza.',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        // we can uncomment below, to allow delete operation.
        // new Delete(),
    ]
)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Range(
        min: 1,
        max: 10,
        notInRangeMessage: 'The star rating should be between {{ min }} and {{ max }}',
    )]
    private ?int $starRating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reviewText = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStarRating(): ?int
    {
        return $this->starRating;
    }

    public function setStarRating(int $starRating): static
    {
        $this->starRating = $starRating;

        return $this;
    }

    public function getReviewText(): ?string
    {
        return $this->reviewText;
    }

    public function setReviewText(?string $reviewText): static
    {
        $this->reviewText = $reviewText;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }
}
