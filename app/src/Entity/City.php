<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
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
    private $localityName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $population;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $coordinate = [];

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $area;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="city")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=StateDepartment::class, inversedBy="cities")
     */
    private $stateDepartment;

    /**
     * @ORM\ManyToOne(targetEntity=Climat::class, inversedBy="cities")
     */
    private $climat;

    /**
     * @ORM\OneToMany(targetEntity=CityPlant::class, mappedBy="city")
     */
    private $cityPlants;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->cityPlants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocalityName(): ?string
    {
        return $this->localityName;
    }

    public function setLocalityName(string $localityName): self
    {
        $this->localityName = $localityName;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(?int $population): self
    {
        $this->population = $population;

        return $this;
    }

    public function getCoordinate(): ?array
    {
        return $this->coordinate;
    }

    public function setCoordinate(?array $coordinate): self
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    public function getArea(): ?float
    {
        return $this->area;
    }

    public function setArea(?float $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCity() === $this) {
                $user->setCity(null);
            }
        }

        return $this;
    }

    public function getStateDepartment(): ?StateDepartment
    {
        return $this->stateDepartment;
    }

    public function setStateDepartment(?StateDepartment $stateDepartment): self
    {
        $this->stateDepartment = $stateDepartment;

        return $this;
    }

    public function getClimat(): ?Climat
    {
        return $this->climat;
    }

    public function setClimat(?Climat $climat): self
    {
        $this->climat = $climat;

        return $this;
    }

    /**
     * @return Collection|CityPlant[]
     */
    public function getCityPlants(): Collection
    {
        return $this->cityPlants;
    }

    public function addCityPlant(CityPlant $cityPlant): self
    {
        if (!$this->cityPlants->contains($cityPlant)) {
            $this->cityPlants[] = $cityPlant;
            $cityPlant->setCity($this);
        }

        return $this;
    }

    public function removeCityPlant(CityPlant $cityPlant): self
    {
        if ($this->cityPlants->removeElement($cityPlant)) {
            // set the owning side to null (unless already changed)
            if ($cityPlant->getCity() === $this) {
                $cityPlant->setCity(null);
            }
        }

        return $this;
    }
}
