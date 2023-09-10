<?php

namespace App\Entity;

use Assert\Length;
use Assert\NotBlank;
use Assert\LessThanOrEqual;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Assert\GreaterThanOrEqual;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\ReviewRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\SearchReviewController;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource(
    shortName: 'MyReview',
    description: 'Car Review Entity - as part of Devish Task done by Ali Mirza.',
    operations: [
        new Get(),
        new GetCollection(uriTemplate: '/my_reviews/list/get'),
        new Post(),
        new Put(),
        new Patch(),
        // we can uncomment below, to allow delete operation.
        // new Delete(),
        // our custom operation
        new GetCollection(
            name: 'searchLatestPositiveReviews',
            uriTemplate: 'my_reviews/list/get/{car.brand}',
            controller: SearchReviewController::class
        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'car.brand' => 'partial',
])]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(10)]
    private ?int $starRating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reviewText = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
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
