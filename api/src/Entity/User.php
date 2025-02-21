<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

#[ApiResource ()]
#[ORM\Entity]
#[ORM\Table(name: '"user"')]
#[UniqueEntity('uuid')]
class User implements UserInterface
{
    #[ORM\Id, ORM\Column(type: 'integer', unique: true, nullable: false), ORM\GeneratedValue(strategy: 'SEQUENCE')]
    private int $id;

    #[ORM\Column(type: 'string', length: 40, unique: true, nullable: false)]
    private ?string $uuid = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $lastName;

    #[ORM\Column(type: 'json')]
    private array $roles;

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
        // Nothing to do
    }

    public function getUserIdentifier(): string
    {
        return $this->uuid;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }
}
