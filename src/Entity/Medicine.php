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

    #[ORM\Column(length: 30)]
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
     * @var Collection<int, BatchMedicine>
     */
    #[ORM\OneToMany(targetEntity: BatchMedicine::class, mappedBy: 'idMed')]
    private Collection $batchMedicines;

    #[ORM\ManyToOne(inversedBy: 'medicines')]
    private ?MedicineCategory $category = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function __construct()
    {
        $this->batchMedicines = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, BatchMedicine>
     */
    public function getBatchMedicines(): Collection
    {
        return $this->batchMedicines;
    }

    public function addBatchMedicine(BatchMedicine $batchMedicine): static
    {
        if (!$this->batchMedicines->contains($batchMedicine)) {
            $this->batchMedicines->add($batchMedicine);
            $batchMedicine->setIdMed($this);
        }

        return $this;
    }

    public function removeBatchMedicine(BatchMedicine $batchMedicine): static
    {
        if ($this->batchMedicines->removeElement($batchMedicine)) {
            // set the owning side to null (unless already changed)
            if ($batchMedicine->getIdMed() === $this) {
                $batchMedicine->setIdMed(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?MedicineCategory
    {
        return $this->category;
    }

    public function setCategory(?MedicineCategory $category): static
    {
        $this->category = $category;

        return $this;
    }
}
