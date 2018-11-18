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
     * Repository to get rooms available for search criteria.
     * This filters rooms by date and by number of guest allowed per room.
     * @param \DateTime $init_date
     * @param \DateTime $end_date
     * @param integer $occupation
     * @return mixed
     */
    public function findByDateRangeAndOccupation($init_date, $end_date, $occupation)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.room_type', 't')
            ->andWhere(':init_date BETWEEN r.init_date AND r.end_date')
            ->andWhere(':end_date BETWEEN r.init_date AND r.end_date')
            ->andWhere('t.allowed_guest >= :occupation')
            ->setParameter('init_date', date('Y-m-d', $init_date->getTimestamp()))
            ->setParameter('end_date', date('Y-m-d',  $end_date->getTimestamp()))
            ->setParameter('occupation', $occupation)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }
}
