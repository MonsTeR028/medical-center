<?php

namespace App\Repository;

use App\Entity\BatchMedicine;
use App\Entity\Medicine;
use App\Entity\OrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderItem>
 */
class OrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }

    public function findOrderItemsByOrderId(int $orderId): array
    {
        return $this->createQueryBuilder('o')
            ->select('o, o.quantity, b, m')
            ->innerJoin('o.idBatchMedicine', 'b')
            ->innerJoin('b.idMed', 'm')
            ->where('o.idOrder = :idOrder')
            ->setParameter('idOrder', $orderId)
            ->orderBy('o.quantity', 'DESC')
            ->getQuery()
            ->getResult();
    }



    //    /**
    //     * @return OrderItem[] Returns an array of OrderItem objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OrderItem
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
