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
    public function search(string $value = '', int $category = 0, string $orderTarget = '', string $orderBy = 'ASC'): array
    {
        $query = $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC')
            ->leftJoin('m.category', 'ctg')
            ->addSelect('ctg as categories')
        ;

        if ('' != $value) {
            $query->andWhere('m.name LIKE :value')
                ->setParameter('value', '%'.$value.'%');
        }

        if (0 != $category) {
            $query->andWhere('ctg.id = :category')
                ->setParameter('category', $category);
        }

        if ('' != $orderTarget && in_array($orderTarget, ['name', 'priceUnit']) && in_array($orderBy, ['ASC', 'DESC'])) {
            $query->orderBy("m.$orderTarget", $orderBy);
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
