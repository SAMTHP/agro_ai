<?php

namespace App\Entity;

use App\Repository\LotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LotRepository::class)
 */
class Lot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lots")
     */
    private $landLord;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $coordinate = [];

    /**
     * @ORM\ManyToOne(targetEntity=Climat::class, inversedBy="lots")
     */
    private $climat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=ProjectLot::class, mappedBy="lot")
     */
    private $projectLots;

    public function __construct()
    {
        $this->projectLots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLandLord(): ?User
    {
        return $this->landLord;
    }

    public function setLandLord(?User $landLord): self
    {
        $this->landLord = $landLord;

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

    public function getClimat(): ?Climat
    {
        return $this->climat;
    }

    public function setClimat(?Climat $climat): self
    {
        $this->climat = $climat;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
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
            $projectLot->setLot($this);
        }

        return $this;
    }

    public function removeProjectLot(ProjectLot $projectLot): self
    {
        if ($this->projectLots->removeElement($projectLot)) {
            // set the owning side to null (unless already changed)
            if ($projectLot->getLot() === $this) {
                $projectLot->setLot(null);
            }
        }

        return $this;
    }
}
