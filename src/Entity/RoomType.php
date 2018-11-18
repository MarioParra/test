<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity to map room's type: individual, double, etc.
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RoomTypeQuantity", mappedBy="room_type")
     */
    private $roomTypeQuantities;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $allowed_guest;

    public function __construct()
    {
        $this->room_price = new ArrayCollection();
        $this->roomPrices = new ArrayCollection();
        $this->roomTypeQuantities = new ArrayCollection();
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

    /**
     * @return Collection|RoomTypeQuantity[]
     */
    public function getRoomTypeQuantities(): Collection
    {
        return $this->roomTypeQuantities;
    }

    public function addRoomTypeQuantity(RoomTypeQuantity $roomTypeQuantity): self
    {
        if (!$this->roomTypeQuantities->contains($roomTypeQuantity)) {
            $this->roomTypeQuantities[] = $roomTypeQuantity;
            $roomTypeQuantity->setRoomType($this);
        }

        return $this;
    }

    public function removeRoomTypeQuantity(RoomTypeQuantity $roomTypeQuantity): self
    {
        if ($this->roomTypeQuantities->contains($roomTypeQuantity)) {
            $this->roomTypeQuantities->removeElement($roomTypeQuantity);
            // set the owning side to null (unless already changed)
            if ($roomTypeQuantity->getRoomType() === $this) {
                $roomTypeQuantity->setRoomType(null);
            }
        }

        return $this;
    }

    public function getAllowedGuest(): ?int
    {
        return $this->allowed_guest;
    }

    public function setAllowedGuest(?int $allowed_guest): self
    {
        $this->allowed_guest = $allowed_guest;

        return $this;
    }
}
