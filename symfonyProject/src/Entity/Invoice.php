<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $number;

    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date")
     */
    private $saleDate;

    /**
     * @ORM\Column(type="date")
     */
    private $paymentDeadline;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\paymentType", inversedBy="priceList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\priceList", inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $priceList;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\contractor", inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\contractor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\priceCurrency")
     * @ORM\JoinColumn(nullable=false)
     */
    private $priceCurrency;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Position", mappedBy="invoice")
     */
    private $positions;

    public function __construct() {
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNumber(): ?string {
        return $this->number;
    }

    public function setNumber(string $number): self {
        $this->number = $number;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getSaleDate(): ?\DateTimeInterface {
        return $this->saleDate;
    }

    public function setSaleDate(\DateTimeInterface $saleDate): self {
        $this->saleDate = $saleDate;

        return $this;
    }

    public function getPaymentDeadline(): ?\DateTimeInterface {
        return $this->paymentDeadline;
    }

    public function setPaymentDeadline(\DateTimeInterface $paymentDeadline): self {
        $this->paymentDeadline = $paymentDeadline;

        return $this;
    }

    public function getPaymentType(): ?paymentType {
        return $this->paymentType;
    }

    public function setPaymentType(?paymentType $paymentType): self {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getPriceList(): ?priceList {
        return $this->priceList;
    }

    public function setPriceList(?priceList $priceList): self {
        $this->priceList = $priceList;

        return $this;
    }

    public function getSeller(): ?contractor {
        return $this->seller;
    }

    public function setSeller(?contractor $seller): self {
        $this->seller = $seller;

        return $this;
    }

    public function getBuyer(): ?contractor {
        return $this->buyer;
    }

    public function setBuyer(?contractor $buyer): self {
        $this->buyer = $buyer;

        return $this;
    }

    public function getPriceCurrency(): ?priceCurrency {
        return $this->priceCurrency;
    }

    public function setPriceCurrency(?priceCurrency $priceCurrency): self {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection {
        return $this->positions;
    }

    public function addPosition(Position $position): self {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setInvoice($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getInvoice() === $this) {
                $position->setInvoice(null);
            }
        }

        return $this;
    }

    // wygenerowanie nowego numeru poprzez wyszkanie ostatniego numeru w bazie(w roku i misiącu utworzenia faktury) i dodanie do niego 1, jeżeli nie ma żadnych faktur numer = 1
    public function setNewNumber(): self {
        $this->number = $number;

        return $this;
    }

    // Podsumowanie faktury
    public function getTotalNettoPrice() {
        $totalNettoPrice = 0;
        foreach ($positions as $position) {
            $totalNettoPrice += $position->getTotalPriceNetto();
        }
        return $totalNettoPrice;
    }

    public function getTotalBruttoPrice() {
        $totalBruttoPrice = 0;
        foreach ($positions as $position) {
            $totalBruttoPrice += $position->getTotalPriceBrutto();
        }
        return $totalBruttoPrice;
    }

    public function getTotalVat() {
        $vat = 0;
        foreach ($positions as $position) {
            $vat += $position->getTotalVatPrice();
        }
        return $vat;
    }

}
