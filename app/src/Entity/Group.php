<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
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
     * @ORM\OneToMany(targetEntity=GroupUser::class, mappedBy="groupLinked")
     */
    private $groupUsers;

    /**
     * @ORM\OneToMany(targetEntity=GroupProject::class, mappedBy="groupLinked")
     */
    private $groupProjects;

    /**
     * @ORM\ManyToMany(targetEntity=Plant::class, mappedBy="groups")
     */
    private $plants;

    public function __construct()
    {
        $this->groupUsers = new ArrayCollection();
        $this->groupProjects = new ArrayCollection();
        $this->plants = new ArrayCollection();
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

    /**
     * @return Collection|GroupUser[]
     */
    public function getGroupUsers(): Collection
    {
        return $this->groupUsers;
    }

    public function addGroupUser(GroupUser $groupUser): self
    {
        if (!$this->groupUsers->contains($groupUser)) {
            $this->groupUsers[] = $groupUser;
            $groupUser->setGroupLinked($this);
        }

        return $this;
    }

    public function removeGroupUser(GroupUser $groupUser): self
    {
        if ($this->groupUsers->removeElement($groupUser)) {
            // set the owning side to null (unless already changed)
            if ($groupUser->getGroupLinked() === $this) {
                $groupUser->setGroupLinked(null);
            }
        }

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
            $groupProject->setGroupLinked($this);
        }

        return $this;
    }

    public function removeGroupProject(GroupProject $groupProject): self
    {
        if ($this->groupProjects->removeElement($groupProject)) {
            // set the owning side to null (unless already changed)
            if ($groupProject->getGroupLinked() === $this) {
                $groupProject->setGroupLinked(null);
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
            $plant->addGroup($this);
        }

        return $this;
    }

    public function removePlant(Plant $plant): self
    {
        if ($this->plants->removeElement($plant)) {
            $plant->removeGroup($this);
        }

        return $this;
    }
}
