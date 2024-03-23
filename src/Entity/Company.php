<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: 'company')]
#[UniqueEntity(fields: ['cnpj'], message: 'This CNPJ is already in use.')]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The name is required.')]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    /**
     * @var State|null
     */
    private ?State $state = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?City $city = null;

    #[ORM\Column(length: 18)]
    #[Assert\NotBlank(message: 'The CNPJ is required.')]
    #[Assert\Regex(
        pattern: '/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/',
        message: 'The CNPJ is invalid.'
    )]
    private ?string $cnpj = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        if ($name !== null) {
            $this->name = $name;
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(?string $cnpj): static
    {
        if ($cnpj !== null) {
            $this->cnpj = $cnpj;
        }
        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;
        return $this;
    }


    public function __toString(): string
    {
        return $this->name ?? '';
    }


}
