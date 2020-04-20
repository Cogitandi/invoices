<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriceRepository")
 */
class Price
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $vat;

    /**
     * @ORM\Column(type="float")
     */
    private $nettoPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\priceList", inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $priceList;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\product", inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Position", mappedBy="price")
     */
    private $positions;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVat(): ?int
    {
        return $this->vat;
    }

    public function setVat(int $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getNettoPrice(): ?float
    {
        return $this->nettoPrice;
    }

    public function setNettoPrice(float $nettoPrice): self
    {
        $this->nettoPrice = $nettoPrice;

        return $this;
    }

    public function getPriceList(): ?priceList
    {
        return $this->priceList;
    }

    public function setPriceList(?priceList $priceList): self
    {
        $this->priceList = $priceList;

        return $this;
    }

    public function getProduct(): ?product
    {
        return $this->product;
    }

    public function setProduct(?product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setPrice($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getPrice() === $this) {
                $position->setPrice(null);
            }
        }

        return $this;
    }
}
