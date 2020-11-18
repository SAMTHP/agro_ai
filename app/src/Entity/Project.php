<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visibility;

    /**
     * @ORM\OneToMany(targetEntity=GroupProject::class, mappedBy="project")
     */
    private $groupProjects;

    /**
     * @ORM\ManyToMany(targetEntity=Plant::class, mappedBy="projects")
     */
    private $plants;

    /**
     * @ORM\OneToMany(targetEntity=ProjectLot::class, mappedBy="project")
     */
    private $projectLots;

    public function __construct()
    {
        $this->groupProjects = new ArrayCollection();
        $this->plants = new ArrayCollection();
        $this->projectLots = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(bool $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * @return Collection|GroupProject[]
     */
    public function getGroupProjects(): Collection
    {
        return $this->groupProjects;
    }

    public function addGroupProject(GroupProject $groupProject): self
    {
        if (!$this->groupProjects->contains($groupProject)) {
            $this->groupProjects[] = $groupProject;
            $groupProject->setProject($this);
        }

        return $this;
    }

    public function removeGroupProject(GroupProject $groupProject): self
    {
        if ($this->groupProjects->removeElement($groupProject)) {
            // set the owning side to null (unless already changed)
            if ($groupProject->getProject() === $this) {
                $groupProject->setProject(null);
            }
        }

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
            $plant->addProject($this);
        }

        return $this;
    }

    public function removePlant(Plant $plant): self
    {
        if ($this->plants->removeElement($plant)) {
            $plant->removeProject($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProjectLot[]
     */
    public function getProjectLots(): Collection
    {
        return $this->projectLots;
    }

    public function addProjectLot(ProjectLot $projectLot): self
    {
        if (!$this->projectLots->contains($projectLot)) {
            $this->projectLots[] = $projectLot;
            $projectLot->setProject($this);
        }

        return $this;
    }

    public function removeProjectLot(ProjectLot $projectLot): self
    {
        if ($this->projectLots->removeElement($projectLot)) {
            // set the owning side to null (unless already changed)
            if ($projectLot->getProject() === $this) {
                $projectLot->setProject(null);
            }
        }

        return $this;
    }
}
