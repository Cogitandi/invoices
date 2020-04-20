<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TownRepository")
 */
class Town
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
     * @ORM\ManyToOne(targetEntity="App\Entity\postCode", inversedBy="towns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\district", inversedBy="towns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $district;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contractor", mappedBy="town")
     */
    private $contractors;

    public function __construct()
    {
        $this->contractors = new ArrayCollection();
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

    public function getPostCode(): ?postCode
    {
        return $this->postCode;
    }

    public function setPostCode(?postCode $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getDistrict(): ?district
    {
        return $this->district;
    }

    public function setDistrict(?district $district): self
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return Collection|Contractor[]
     */
    public function getContractors(): Collection
    {
        return $this->contractors;
    }

    public function addContractor(Contractor $contractor): self
    {
        if (!$this->contractors->contains($contractor)) {
            $this->contractors[] = $contractor;
            $contractor->setTown($this);
        }

        return $this;
    }

    public function removeContractor(Contractor $contractor): self
    {
        if ($this->contractors->contains($contractor)) {
            $this->contractors->removeElement($contractor);
            // set the owning side to null (unless already changed)
            if ($contractor->getTown() === $this) {
                $contractor->setTown(null);
            }
        }

        return $this;
    }
}
