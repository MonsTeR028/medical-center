<?php

namespace App\Entity;

use App\Repository\PurchaseItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseItemRepository::class)]
class PurchaseItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Purchase $idPurchase = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BatchMedicine $idBatchMedicine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getIdPurchase(): ?Purchase
    {
        return $this->idPurchase;
    }

    public function setIdPurchase(?Purchase $idPurchase): static
    {
        $this->idPurchase = $idPurchase;

        return $this;
    }

    public function getIdBatchMedicine(): ?BatchMedicine
    {
        return $this->idBatchMedicine;
    }

    public function setIdBatchMedicine(?BatchMedicine $idBatchMedicine): static
    {
        $this->idBatchMedicine = $idBatchMedicine;

        return $this;
    }
}
