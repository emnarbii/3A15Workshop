<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findByNbBook($min, $max): ?Author
       {
           return $this->createQueryBuilder('a')
               ->where('a.nbBook  BETWEEN :min and :max')
               ->andWhere('a.exampleField = :val')
               ->setParameter('min', $min)
               ->setParameter('max', $max)
               ->getQuery()
               ->getResult()
           ;
       }

    //exemple avec DQL:Doctrine Query Language
    public function getAllAUthors()
    {
        $em = $this->getEntityManager();
        return $em->createQuery('Select a from App\Entity\Author a')
            ->getResult();
    }

    public function getAuthByName($name)
    {
        $em = $this->getEntityManager();
        return $em->createQuery('Select a from App\Entity\Author a where a.authorName=:name')
            ->setParameter('name', $name)
            ->getResult();
    }
}
