<?php

namespace App\Repository;

use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etudiant>
 *
 * @method Etudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etudiant[]    findAll()
 * @method Etudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Etudiant $entity, bool $flush = true): void
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
    public function remove(Etudiant $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Etudiant[] Returns an array of Etudiant objects
     */
    
    public function findEtudiant($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.groupe = :groupe')
            ->setParameter('groupe', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Etudiant[] Returns an array of Etudiant objects
     */
    
    public function findEtudiantCne($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.cne = :cne')
            ->setParameter('cne', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Etudiant[] Returns an array of Etudiant objects
     */
    
    public function findEtudiantCentre($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.centre = :centre')
            ->setParameter('centre', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Etudiant
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
