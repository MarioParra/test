<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomTypeQuantityRepository")
 */
class RoomTypeQuantity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $init_date;

    /**
     * @ORM\Column(type="date")
     */
    private $end_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RoomType", inversedBy="roomTypeQuantities")
     */
    private $room_type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitDate(): ?\DateTimeInterface
    {
        return $this->init_date;
    }

    public function setInitDate(\DateTimeInterface $init_date): self
    {
        $this->init_date = $init_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRoomType(): ?RoomType
    {
        return $this->room_type;
    }

    public function setRoomType(?RoomType $room_type): self
    {
        $this->room_type = $room_type;

        return $this;
    }
}
