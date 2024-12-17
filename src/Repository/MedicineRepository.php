<?php

namespace App\Repository;

use App\Entity\Medicine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medicine>
 */
class MedicineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicine::class);
    }

    /**
     * @return Medicine[]
     */
    public function search(string $value = '', int $category = 0): array
    {
        $query = $this->createQueryBuilder('m')
            ->addOrderBy('m.name', 'ASC')
            ->leftJoin('m.category', 'ctg')
            ->addSelect('ctg as categories')
        ;

        if ('' != $value) {
            $query->andWhere('m.name LIKE :value')
                ->setParameter('value', $value.'%');
        }

        if(0 != $category) {
            $query->andWhere('ctg.id = :category')
                ->setParameter('category', $category);
        }

        return $query->getQuery()->getResult();
    }

    public function findWithCategory(int $id): ?Medicine
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.category', 'ctg')
            ->addSelect('ctg as category')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }
}
