<?php

namespace App\Repository;

use App\Entity\RoomTypeQuantity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RoomTypeQuantity|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomTypeQuantity|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomTypeQuantity[]    findAll()
 * @method RoomTypeQuantity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomTypeQuantityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoomTypeQuantity::class);
    }

    /**
     * @param \DateTime $init_date
     * @param \DateTime $end_date
     * @return mixed
     */
    public function findByDateRangeAndQuantity($init_date, $end_date)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.init_date >= :init_date')
            ->andWhere('r.end_date <= :end_date')
            ->setParameter('init_date', date('Y-m-d H:i:s', $init_date->getTimestamp()))
            ->setParameter('end_date', date('Y-m-d H:i:s', $end_date->getTimestamp()))
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return RoomTypeQuantity[] Returns an array of RoomTypeQuantity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoomTypeQuantity
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
