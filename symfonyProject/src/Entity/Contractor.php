<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractorRepository")
 */
class Contractor {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=26)
     */
    private $string;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $nip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $regon;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\bank", inversedBy="contractors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bank;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\town", inversedBy="contractors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $town;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invoice", mappedBy="seller")
     */
    private $invoices;

    /**
     * @ORM\Column(type="string", length=26)
     */
    private $bankAccountNumber;

    public function __construct() {
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCompanyName(): ?string {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self {
        $this->companyName = $companyName;

        return $this;
    }

    public function getString(): ?string {
        return $this->string;
    }

    public function setString(string $string): self {
        $this->string = $string;

        return $this;
    }

    public function getNip(): ?string {
        return $this->nip;
    }

    public function setNip(?string $nip): self {
        $this->nip = $nip;

        return $this;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(string $address): self {
        $this->address = $address;

        return $this;
    }

    public function getRegon(): ?string {
        return $this->regon;
    }

    public function setRegon(?string $regon): self {
        $this->regon = $regon;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setPhone(?string $phone): self {
        $this->phone = $phone;

        return $this;
    }

    public function getBank(): ?bank {
        return $this->bank;
    }

    public function setBank(?bank $bank): self {
        $this->bank = $bank;

        return $this;
    }

    public function getTown(): ?town {
        return $this->town;
    }

    public function setTown(?town $town): self {
        $this->town = $town;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setSeller($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getSeller() === $this) {
                $invoice->setSeller(null);
            }
        }

        return $this;
    }

    public function getBankAccountNumber(): ?string {
        return $this->bankAccountNumber;
    }

    public function setBankAccountNumber(string $bankAccountNumber): self {
        $this->bankAccountNumber = $bankAccountNumber;

        return $this;
    }

    // Sprawdza poprawność nr. konta bankowego
    function checkBankAccountNumber($accountNumber) {
        return preg_match('/^[0-9]{26}$/', $accountNumber);
    }

    // Werfyfikacja nipu, regonu za pomocą API  https://api.stat.gov.pl/Home/RegonApi
}
