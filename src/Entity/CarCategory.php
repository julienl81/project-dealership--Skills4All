<?php

namespace App\Entity;

use App\Repository\CarCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarCategoryRepository::class)]
class CarCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'carCategory', targetEntity: Car::class)]
    private Collection $carId;

    public function __construct()
    {
        $this->carId = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->name;
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
     * @return Collection<int, Car>
     */
    public function getCarId(): Collection
    {
        return $this->carId;
    }

    public function addCarId(Car $carId): self
    {
        if (!$this->carId->contains($carId)) {
            $this->carId->add($carId);
            $carId->setCarCategory($this);
        }

        return $this;
    }

    public function removeCarId(Car $carId): self
    {
        if ($this->carId->removeElement($carId)) {
            // set the owning side to null (unless already changed)
            if ($carId->getCarCategory() === $this) {
                $carId->setCarCategory(null);
            }
        }

        return $this;
    }
}
