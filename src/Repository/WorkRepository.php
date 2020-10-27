<?php

namespace App\Repository;

use App\Entity\Work;
use App\Entity\Search\SearchWork;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Work|null find($id, $lockMode = null, $lockVersion = null)
 * @method Work|null findOneBy(array $criteria, array $orderBy = null)
 * @method Work[]    findAll()
 * @method Work[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Work::class);
    }

     /**
    * @return Project[] Returns an array of Project objects
    */
    
    public function findByCriteria(SearchWork $criteria) : array
    {
        $query = $this
            ->createQueryBuilder('w')
            ->orderBy('w.id', 'ASC')
        ;
        if(!empty($criteria->title)){
            $query = $query
                ->andwhere('w.title LIKE :title')
                ->setParameter('title', "%{$criteria->title}%");
        }

        if(!empty($criteria->id)){
            $query = $query
                ->andwhere('w.id LIKE :id')
                ->setParameter('id', "%{$criteria->id}%");
        }

        if(!empty($criteria->nationality)){
            $query = $query
                ->andwhere('w.nationality LIKE :nationality')
                ->setParameter('nationality', "%{$criteria->nationality}%");
        }

        if(!empty($criteria->year)){
            $query = $query
                ->andwhere('w.yearOfCopyright LIKE :year')
                ->setParameter('year', "%{$criteria->year}%");
        }

        if(!empty($criteria->status)){
            $query = $query
                ->andwhere('w.status LIKE :status')
                ->setParameter('status', "%{$criteria->status}%");
        }
        return $query
            ->getQuery()
            ->getResult()
        ;
    }
    

    /**
    * @return Work[] Returns an array of Work objects
    */
    
    public function findCrewDirectors()
    {
        return $this->createQueryBuilder('w')
            ->andWhere('person.role = :role')
            ->setParameter('role', 'Director')
            ->leftJoin('w.id','crew')
            ->leftJoin('crew.person_id','person')
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByTitle(String $criteria) : array
    {
        $query = $this
            ->createQueryBuilder('w')
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
        ;
        if(!empty($criteria)){
            $query = $query
                ->andwhere('w.title LIKE :title')
                ->setParameter('title', "%$criteria%");
        }
        return $query
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findOneBySomeField($value): ?Work
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
