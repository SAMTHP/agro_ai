<?php

namespace App\Entity;

use App\Repository\CityPlantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityPlantRepository::class)
 */
class CityPlant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Season::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="cityPlants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=Plant::class, inversedBy="cityPlants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plant;

    /**
     * @ORM\Column(type="date")
     */
    private $year;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantitySold;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantityProduced;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPlant(): ?Plant
    {
        return $this->plant;
    }

    public function setPlant(?Plant $plant): self
    {
        $this->plant = $plant;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getQuantitySold(): ?float
    {
        return $this->quantitySold;
    }

    public function setQuantitySold(?float $quantitySold): self
    {
        $this->quantitySold = $quantitySold;

        return $this;
    }

    public function getQuantitySoldInKg(): ?float
    {
        return $this->quantitySold / 1000;
    }

    public function setQuantitySoldInKg(?float $quantitySold): self
    {
        $this->quantitySold = $quantitySold * 1000;

        return $this;
    }

    public function getQuantityProduced(): ?float
    {
        return $this->quantityProduced;
    }

    public function setQuantityProduced(?float $quantityProduced): self
    {
        $this->quantityProduced = $quantityProduced;

        return $this;
    }

    public function getQuantityProducedInKg(): ?float
    {
        return $this->quantityProduced / 1000;
    }

    public function setQuantityProducedInKg(?float $quantityProduced): self
    {
        $this->quantityProduced = $quantityProduced * 1000;

        return $this;
    }
}
