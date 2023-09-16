<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Review;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class SearchReview extends AbstractController
{
    public function __construct(private ReviewRepository $repo)
    {
        $this->repo = $repo;
    }
    
    public function __invoke(Car $car): ?array
    {
        if(!$car) 
        {
            throw $this->createNotFoundException('car not found');
        }

        $reviews = $this->repo->findLatestPositiveReviewsOfSpecificCar($car);
        // dd($reviews);
 
        if (!$reviews || count($reviews) === 0) 
        {
            throw $this->createNotFoundException(
                'No reviews found for the given car.'
            );
        }
 
        return $reviews;
    }
}
