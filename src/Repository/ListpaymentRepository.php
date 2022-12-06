<?php

namespace App\Repository;

use App\Entity\Listpayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Listpayment>
 *
 * @method Listpayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Listpayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Listpayment[]    findAll()
 * @method Listpayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListpaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Listpayment::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Listpayment $entity, bool $flush = true): void
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
    public function remove(Listpayment $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Listpayment[] Returns an array of Listpayment objects
     */
    
    public function findListPayment($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.cne = :cne')
            ->setParameter('cne', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Listpayment
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
