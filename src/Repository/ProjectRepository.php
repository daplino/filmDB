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
                ->andwhere('p.action = :action')
                
                ->setParameter('action', "{$criteria->action}");
        }
        
        if(!empty($criteria->year)){
            $query = $query
                ->andwhere('p.year LIKE :year')
                ->setParameter('year', "%{$criteria->year}%");
        }

        if(!empty($criteria->round)){
            $query = $query
                ->andwhere('p.round LIKE :round')
                ->setParameter('round', "%{$criteria->round}%");
        }
        return $query
            ->getQuery()
            ->getResult()
        ;
    }
    

    
    public function countProjectsPerAction() : array
    {
        return $this->createQueryBuilder('p')
            ->addSelect('COUNT(p.id) as count')
            ->groupBy('p.action')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(30)->getQuery()
            ->getResult();
        
    }
    
}
