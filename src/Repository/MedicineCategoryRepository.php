<?php

namespace App\Repository;

use App\Entity\MedicineCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MedicineCategory>
 */
class MedicineCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicineCategory::class);
    }

    /**
     * @return MedicineCategory[] Returns an array of MedicineCategory objects ordered by name ASC
     */
    public function findAllOrderedByName(): array
    {
        return $this->createQueryBuilder('mc')
            ->orderBy('mc.name', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
