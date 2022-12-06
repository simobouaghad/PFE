<?php

namespace App\Repository;

use App\Entity\Employeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employeur>
 *
 * @method Employeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employeur[]    findAll()
 * @method Employeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employeur::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Employeur $entity, bool $flush = true): void
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
    public function remove(Employeur $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Employeur[] Returns an array of Employeur objects
     */
    
    public function findEmployeurCentre($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.centre = :centre')
            ->setParameter('centre', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Employeur
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
