<?php

namespace App\Entity;

use App\Repository\ClimatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClimatRepository::class)
 */
class Climat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $infos = [];

    /**
     * @ORM\ManyToMany(targetEntity=Plant::class, inversedBy="climats")
     */
    private $plants;

    /**
     * @ORM\OneToMany(targetEntity=Lot::class, mappedBy="climat")
     */
    private $lots;

    /**
     * @ORM\OneToMany(targetEntity=City::class, mappedBy="climat")
     */
    private $cities;

    public function __construct()
    {
        $this->plants = new ArrayCollection();
        $this->lots = new ArrayCollection();
        $this->cities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getInfos(): ?array
    {
        return $this->infos;
    }

    public function setInfos(?array $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * @return Collection|Plant[]
     */
    public function getPlants(): Collection
    {
        return $this->plants;
    }

    public function addPlant(Plant $plant): self
    {
        if (!$this->plants->contains($plant)) {
            $this->plants[] = $plant;
            $plant->addClimat($this);
        }

        return $this;
    }

    public function removePlant(Plant $plant): self
    {
        $this->plants->removeElement($plant);

        return $this;
    }

    /**
     * @return Collection|Lot[]
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): self
    {
        if (!$this->lots->contains($lot)) {
            $this->lots[] = $lot;
            $lot->setClimat($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): self
    {
        if ($this->lots->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getClimat() === $this) {
                $lot->setClimat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
            $city->setClimat($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getClimat() === $this) {
                $city->setClimat(null);
            }
        }

        return $this;
    }
}
