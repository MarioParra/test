<?php

namespace App\Repository;

use App\Entity\RoomPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RoomPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomPrice[]    findAll()
 * @method RoomPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomPriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoomPrice::class);
    }
}
