<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Breed>
     */
    #[ORM\OneToMany(targetEntity: Breed::class, mappedBy: 'type')]
    private Collection $breeds;

    public function __construct()
    {
        $this->breeds = new ArrayCollection();
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
     * @return Collection<int, Breed>
     */
    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function addBreed(Breed $breed): static
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds->add($breed);
            $breed->setType($this);
        }

        return $this;
    }

    public function removeBreed(Breed $breed): static
    {
        if ($this->breeds->removeElement($breed)) {
            // set the owning side to null (unless already changed)
            if ($breed->getType() === $this) {
                $breed->setType(null);
            }
        }

        return $this;
    }


}
