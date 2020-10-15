<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Search\SearchProject;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    
    /**
    * @return Project[] Returns an array of Project objects
    */
    
    public function findByCriteria(SearchProject $criteria) : array
    {
        $query = $this
            ->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
        ;

        if(!empty($criteria->action)){
            $query = $query
                ->andwhere('p.action LIKE :action')
                ->setParameter('action', "%{$criteria->action}%");
        }
        return $query
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
