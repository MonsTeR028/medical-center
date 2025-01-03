<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Supplier>
     */
    #[ORM\OneToMany(targetEntity: Supplier::class, mappedBy: 'purchase')]
    private Collection $idSupp;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalAmount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $purchaseDate = null;

    /**
     * @var Collection<int, PurchaseItem>
     */
    #[ORM\OneToMany(targetEntity: PurchaseItem::class, mappedBy: 'idPurchase')]
    private Collection $purchaseItems;

    public function __construct()
    {
        $this->idSupp = new ArrayCollection();
        $this->purchaseItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, Supplier>
     */
    public function getIdSupp(): Collection
    {
        return $this->idSupp;
    }

    public function addIdSupp(Supplier $idSupp): static
    {
        if (!$this->idSupp->contains($idSupp)) {
            $this->idSupp->add($idSupp);
            $idSupp->setPurchase($this);
        }

        return $this;
    }

    public function removeIdSupp(Supplier $idSupp): static
    {
        if ($this->idSupp->removeElement($idSupp)) {
            // set the owning side to null (unless already changed)
            if ($idSupp->getPurchase() === $this) {
                $idSupp->setPurchase(null);
            }
        }

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(\DateTimeInterface $purchaseDate): static
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * @return Collection<int, PurchaseItem>
     */
    public function getPurchaseItems(): Collection
    {
        return $this->purchaseItems;
    }

    public function addPurchaseItem(PurchaseItem $purchaseItem): static
    {
        if (!$this->purchaseItems->contains($purchaseItem)) {
            $this->purchaseItems->add($purchaseItem);
            $purchaseItem->setIdPurchase($this);
        }

        return $this;
    }

    public function removePurchaseItem(PurchaseItem $purchaseItem): static
    {
        if ($this->purchaseItems->removeElement($purchaseItem)) {
            // set the owning side to null (unless already changed)
            if ($purchaseItem->getIdPurchase() === $this) {
                $purchaseItem->setIdPurchase(null);
            }
        }

        return $this;
    }
}
