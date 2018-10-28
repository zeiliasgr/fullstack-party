<?php

namespace App\Repository;

use App\Entity\Issue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Issue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Issue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Issue[]    findAll()
 * @method Issue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IssueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Issue::class);
    }

    private function countStatus($val){
        try{
            $result = $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->andWhere('i.openStatus = :val')
            ->setParameter('val', $val)
            ->getQuery()
            ->getSingleScalarResult();
        }
        catch(\Doctrine\ORM\NoResultException  $e){
            $result = 0;
        }

        return $result;
    }


    public function openIssues(){
        return $this->countStatus(1);
    }

    public function closedIssues(){
        return $this->countStatus(0);
    }


//    /**
//     * @return Issue[] Returns an array of Issue objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Issue
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
