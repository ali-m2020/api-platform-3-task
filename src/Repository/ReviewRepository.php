<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    /** 
     * POSITIVE_RATING_THRESHOLD refers to a minimum rating (1-10), that is considered to be a positive feedback
     * as per the Devish task instruction, I set it to 6
     */
    private int $POSITIVE_RATING_THRESHOLD;
    
    private int $MAX_RESULTS;

    public function __construct(ManagerRegistry $registry, int $POSITIVE_RATING_THRESHOLD, int $MAX_RESULTS)
    {
        $this->POSITIVE_RATING_THRESHOLD = $POSITIVE_RATING_THRESHOLD;
        $this->MAX_RESULTS = $MAX_RESULTS;

        parent::__construct($registry, Review::class);
    }

   /**
    * @var int|null $carId
    * @return Review[] Returns an array of Review objects
    */
   public function findLatestPositiveReviewsOfSpecificCar(?int $carId): array
   {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.car', 'c')
            ->addSelect('c')
            ->andWhere('c.id = :carId')
            ->andWhere('r.starRating => :positiveThreshold')
            ->setParameter('carId', $carId)
            ->setParameter('positiveThreshold', $this->POSITIVE_RATING_THRESHOLD)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults($this->MAX_RESULTS)
            ->getQuery()
            ->getResult()
       ;
   }

   /**
    * @var string|null $brandName
    * @return Review[] Returns an array of Review objects
    */
   public function findLatestPositiveReviewsOfSpecificBrand(?string $brandName): array
   {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.car', 'c')
            ->addSelect('c')
            ->andWhere('c.brand = :brandName')
            ->andWhere('r.starRating >= :positiveThreshold')
            ->setParameter('brandName', $brandName)
            ->setParameter('positiveThreshold', $this->POSITIVE_RATING_THRESHOLD)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults($this->MAX_RESULTS)
            ->getQuery()
            ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Review
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
