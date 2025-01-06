<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 25,
        minMessage: 'Votre téléphone doit faire au moins {{ limit }} caractères',
        maxMessage: 'Votre téléphone ne doit pas faire plus de {{ limit }} caractères',
    )]
    #[Assert\Regex(pattern: '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4})$/',
        message: 'Format de téléphone invalide')]
    private ?string $phone = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: 'Votre email doit faire au moins {{ limit }} caractères',
        maxMessage: 'Votre email ne doit pas faire plus de {{ limit }} caractères',
    )]
    #[Assert\Email(
        message: '{{ value }} n\'est pas un email valide.',
    )]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'idSupp')]
    private ?Purchase $purchase = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): static
    {
        $this->purchase = $purchase;

        return $this;
    }
}
