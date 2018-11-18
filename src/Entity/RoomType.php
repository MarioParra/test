<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomTypeRepository")
 */
class RoomType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RoomPrice", mappedBy="room_type_id", orphanRemoval=true)
     */
    private $room_price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RoomPrice", mappedBy="room_type")
     */
    private $roomPrices;

    public function __construct()
    {
        $this->room_price = new ArrayCollection();
        $this->roomPrices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|RoomPrice[]
     */
    public function getRoomPrices(): Collection
    {
        return $this->roomPrices;
    }

    public function addRoomPrice(RoomPrice $roomPrice): self
    {
        if (!$this->roomPrices->contains($roomPrice)) {
            $this->roomPrices[] = $roomPrice;
            $roomPrice->setRoomType($this);
        }

        return $this;
    }

    public function removeRoomPrice(RoomPrice $roomPrice): self
    {
        if ($this->roomPrices->contains($roomPrice)) {
            $this->roomPrices->removeElement($roomPrice);
            // set the owning side to null (unless already changed)
            if ($roomPrice->getRoomType() === $this) {
                $roomPrice->setRoomType(null);
            }
        }

        return $this;
    }
}
