<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="sp_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = false;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(name="expiration", type="datetime")
     */
    private $expiration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="locked_until", type="datetime")
     */
    private $lockedUntil;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime")
     */
    private $lastLogin;

    /**
     * @var int
     *
     * @ORM\Column(name="failed_logins", type="integer", nullable=false)
     */
    private $failedLogins = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=40, nullable=true)
     */
    private $confirmationToken = '';

    /**
     * One Product has Many Features.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="user")
     */
    private $applications;

    /**
     * @var ArrayCollection
     *
     * Many Users have Many Roles.
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     * @ORM\JoinTable(
     *     name="sp_users_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->lastLogin = new \DateTime();
        $this->lockedUntil = new \DateTime();
        $this->created = new \DateTime();
        $this->roles = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return array_map(function ($role) {
            return $role->getName();
        }, $this->roles->toArray());
    }

    /**
     * @param Role $role
     * @return User
     */
    public function addRole(Role $role): self
    {
        $this->roles->add($role);
        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param $expiration
     * @return User
     */
    public function setExpiration($expiration): self
    {
        $this->expiration = $expiration;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLockedUntil(): \DateTime
    {
        return $this->lockedUntil;
    }

    /**
     * @param \DateTime $lockedUntil
     */
    public function setLockedUntil(\DateTime $lockedUntil): void
    {
        $this->lockedUntil = $lockedUntil;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin(): \DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin(\DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return int
     */
    public function getFailedLogins(): int
    {
        return $this->failedLogins;
    }

    /**
     * @param int $failedLogins
     */
    public function setFailedLogins(int $failedLogins): void
    {
        $this->failedLogins = $failedLogins;
    }

    /**
     * @return string
     */
    public function getConfirmationToken(): string
    {
        return $this->confirmationToken;
    }

    /**
     * @param string $confirmationToken
     */
    public function setConfirmationToken(string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @return ArrayCollection
     */
    public function getApplications(): ArrayCollection
    {
        return $this->applications;
    }

    /**
     * @param ArrayCollection $applications
     */
    public function setApplications(ArrayCollection $applications): void
    {
        $this->applications = $applications;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
