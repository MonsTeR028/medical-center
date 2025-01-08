<?php

namespace App\Repository;

use App\Entity\BatchMedicine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BatchMedicine>
 */
class BatchMedicineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BatchMedicine::class);
    }

    public function findAllQuantityById($id): int
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b.id)')
            ->setParameter(':id', $id)
            ->where('b.idMed = :id')
            ->andWhere('b.arrivalDate <= CURRENT_TIMESTAMP()')
            ->getQuery()
            ->getSingleScalarResult();
    }

    //    /**
    //     * @return BatchMedicine[] Returns an array of BatchMedicine objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BatchMedicine
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
