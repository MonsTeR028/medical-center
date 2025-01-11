<?php

namespace App\Entity;

use App\Repository\MedicineCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicineCategoryRepository::class)]
class MedicineCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    /**
     * @var Collection<int, Medicine>
     */
    #[ORM\OneToMany(targetEntity: Medicine::class, mappedBy: 'category')]
    private Collection $medicines;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $color = null;

    public function __construct()
    {
        $this->medicines = new ArrayCollection();
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

    /**
     * @return Collection<int, Medicine>
     */
    public function getMedicines(): Collection
    {
        return $this->medicines;
    }

    public function addMedicine(Medicine $medicine): static
    {
        if (!$this->medicines->contains($medicine)) {
            $this->medicines->add($medicine);
            $medicine->setCategory($this);
        }

        return $this;
    }

    public function removeMedicine(Medicine $medicine): static
    {
        if ($this->medicines->removeElement($medicine)) {
            // set the owning side to null (unless already changed)
            if ($medicine->getCategory() === $this) {
                $medicine->setCategory(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color ?? "000000";
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }
}
