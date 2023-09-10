<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class SearchReviewController extends AbstractController
{
    #[Route(
        path: '/api/my_reviews/latest_positive/{car_brand}', 
        name: 'searchLatestPositiveReviewsForSpecificBrand', 
        methods: ['GET'],
        defaults: [
            '_api_resource_class' => Review::class,
            '_api_operation_name' => 'searchLatestPositiveReviews',
        ],
    )]

    // public function searchLatestPositiveReviewsForSpecificBrand(?string $carBrand, ReviewRepository $repo)
    public function __invoke(ReviewRepository $repo, string $car_brand = null)
    {
        if(!$car_brand) 
        {
            throw $this->createNotFoundException('carBrand was empty');
        }

        $reviews = $repo->findLatestPositiveReviewsOfSpecificBrand($car_brand);
        // dd($reviews);
 
        if (!$reviews || count($reviews) === 0) 
        {
            throw $this->createNotFoundException(
                'No reviews found for the searched car.'
            );
        }
 
        return $reviews;
    }
}
