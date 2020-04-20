<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PositionRepository")
 */
class Position
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
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\price", inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\invoice", inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $invoice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?price
    {
        return $this->price;
    }

    public function setPrice(?price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getInvoice(): ?invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }
    
    public function getTotalPriceNetto() {
        return $price->getNettoPrice()*$quantity;
    }
    
    public function getTotalPriceBrutto() {
        return $this->getTotalPriceNetto() + $this->getTotalVatPrice();
    }
    
    public function getTotalVatPrice() {
        $vat = $this->getTotalPriceNetto() * ($this->price->getVat()/100);
        return $vat;
    }
}
