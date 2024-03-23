<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StateRepository::class)]
#[ORM\Table(name: 'state')]
class State
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The name is required.')]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    #[Assert\NotBlank(message: 'The uf is required.')]
    private ?string $uf = null;

    #[ORM\OneToMany(targetEntity: City::class, mappedBy: 'state')]
    private Collection $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
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

    public function getUf(): ?string
    {
        return $this->uf;
    }

    public function setUf(string $uf): static
    {
        $this->uf = $uf;

        return $this;
    }

    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
            $city->setState($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getState() === $this) {
                $city->setState(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
