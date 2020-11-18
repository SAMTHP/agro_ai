<?php

namespace App\Entity;

use App\Repository\GroupProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupProjectRepository::class)
 */
class GroupProject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="groupProjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupLinked;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="groupProjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getGroupLinked(): ?Group
    {
        return $this->groupLinked;
    }

    public function setGroupLinked(?Group $groupLinked): self
    {
        $this->groupLinked = $groupLinked;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
