<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistrictRepository")
 */
class District
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\voivodeship", inversedBy="districts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voivodeship;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Town", mappedBy="district")
     */
    private $towns;

    public function __construct()
    {
        $this->towns = new ArrayCollection();
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

    public function getVoivodeship(): ?voivodeship
    {
        return $this->voivodeship;
    }

    public function setVoivodeship(?voivodeship $voivodeship): self
    {
        $this->voivodeship = $voivodeship;

        return $this;
    }

    /**
     * @return Collection|Town[]
     */
    public function getTowns(): Collection
    {
        return $this->towns;
    }

    public function addTown(Town $town): self
    {
        if (!$this->towns->contains($town)) {
            $this->towns[] = $town;
            $town->setDistrict($this);
        }

        return $this;
    }

    public function removeTown(Town $town): self
    {
        if ($this->towns->contains($town)) {
            $this->towns->removeElement($town);
            // set the owning side to null (unless already changed)
            if ($town->getDistrict() === $this) {
                $town->setDistrict(null);
            }
        }

        return $this;
    }
}
