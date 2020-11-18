<?php

namespace App\Entity;

use App\Repository\PlantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlantRepository::class)
 */
class Plant
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vernicular;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, inversedBy="plants")
     */
    private $projects;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, inversedBy="plants")
     */
    private $groups;

    /**
     * @ORM\ManyToMany(targetEntity=Climat::class, mappedBy="plants")
     */
    private $climats;

    /**
     * @ORM\OneToMany(targetEntity=CityPlant::class, mappedBy="plant")
     */
    private $cityPlants;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->climats = new ArrayCollection();
        $this->cityPlants = new ArrayCollection();
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

    public function getVernicular(): ?string
    {
        return $this->vernicular;
    }

    public function setVernicular(?string $vernicular): self
    {
        $this->vernicular = $vernicular;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        $this->projects->removeElement($project);

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        $this->groups->removeElement($group);

        return $this;
    }

    /**
     * @return Collection|Climat[]
     */
    public function getClimats(): Collection
    {
        return $this->climats;
    }

    public function addClimat(Climat $climat): self
    {
        if (!$this->climats->contains($climat)) {
            $this->climats[] = $climat;
            $climat->addPlant($this);
        }

        return $this;
    }

    public function removeClimat(Climat $climat): self
    {
        if ($this->climats->removeElement($climat)) {
            $climat->removePlant($this);
        }

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
            $cityPlant->setPlant($this);
        }

        return $this;
    }

    public function removeCityPlant(CityPlant $cityPlant): self
    {
        if ($this->cityPlants->removeElement($cityPlant)) {
            // set the owning side to null (unless already changed)
            if ($cityPlant->getPlant() === $this) {
                $cityPlant->setPlant(null);
            }
        }

        return $this;
    }
}
