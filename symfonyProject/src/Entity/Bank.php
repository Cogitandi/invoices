<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BankRepository")
 */
class Bank
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $swift;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $disable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contractor", mappedBy="bank")
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

    public function getSwift(): ?string
    {
        return $this->swift;
    }

    public function setSwift(string $swift): self
    {
        $this->swift = $swift;

        return $this;
    }

    public function getDisable(): ?bool
    {
        return $this->disable;
    }

    public function setDisable(?bool $disable): self
    {
        $this->disable = $disable;

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
            $contractor->setBank($this);
        }

        return $this;
    }

    public function removeContractor(Contractor $contractor): self
    {
        if ($this->contractors->contains($contractor)) {
            $this->contractors->removeElement($contractor);
            // set the owning side to null (unless already changed)
            if ($contractor->getBank() === $this) {
                $contractor->setBank(null);
            }
        }

        return $this;
    }
}
