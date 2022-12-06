<?php

namespace App\Repository;

use App\Entity\Matire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matire>
 *
 * @method Matire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matire[]    findAll()
 * @method Matire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matire::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Matire $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Matire $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Matire[] Returns an array of Matire objects
     */
    
    public function findMatireCentre($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.centre = :centre')
            ->setParameter('centre', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Matire[] Returns an array of Matire objects
     */
    
    public function findMatireSousCat($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.sousCategory = :sousCategory')
            ->setParameter('sousCategory', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Matire
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
