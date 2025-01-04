<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $idOrder = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BatchMedicine $idBatchMedicine = null;

    #[Assert\NotNull(message: 'La quantité doit être renseignée.')]
    #[Assert\GreaterThan(0, message: 'La quantité doit être supérieure à 0.')]
    #[ORM\Column(type: 'integer')]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getIdOrder(): ?Order
    {
        return $this->idOrder;
    }

    public function setIdOrder(?Order $idOrder): static
    {
        $this->idOrder = $idOrder;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
