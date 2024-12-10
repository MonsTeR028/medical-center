<?php

namespace App\Entity;

use App\Repository\MedicineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedicineRepository::class)]
class Medicine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Le nom du médicament doit être renseigné.')]
    #[Assert\Length(max: 50, maxMessage: 'Le nom du médicament doit être inférieur à 50 caractères.')]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column(length: 10)]
    private ?string $dosage = null;

    #[Assert\NotBlank(message: 'Le prix unitaire doit être renseigné.')]
    #[Assert\GreaterThan(value: 0, message: 'Le prix unitaire doit être supérieur à 0.')]
    #[ORM\Column]
    private ?float $priceUnit = null;

    #[Assert\NotBlank(message: 'Le descriptif doit être renseigné.')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFileName = null;

    /**
     * @var Collection<int, MedicineCategory>
     */
    #[ORM\ManyToMany(targetEntity: MedicineCategory::class, inversedBy: 'medicines')]
    private Collection $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): static
    {
        $this->dosage = $dosage;

        return $this;
    }

    public function getPriceUnit(): ?float
    {
        return $this->priceUnit;
    }

    public function setPriceUnit(float $priceUnit): static
    {
        $this->priceUnit = $priceUnit;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): static
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }

    /**
     * @return Collection<int, MedicineCategory>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(MedicineCategory $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(MedicineCategory $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }
}
