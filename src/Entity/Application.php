<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="sp_application")
 * @ORM\Entity
 */
class Application
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = '';

    /**
     * @var string
     *
     * @ORM\Column(name="api_key", type="string", length=40, nullable=false)
     */
    private $apiKey = '';

    /**
     * Many Applications have One User.
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="applications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Many Applications have One DisplayPreset.
     * @ORM\ManyToOne(targetEntity="App\Entity\DisplayPreset")
     * @ORM\JoinColumn(name="display_preset_id", referencedColumnName="id")
     */
    private $displayPreset;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Profile", mappedBy="application")
     */
    private $profiles;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->profiles = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Application
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Application
     */
    public function setDescription(string $description): Application
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return Application
     */
    public function setApiKey($apiKey): Application
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Application
     */
    public function setUser(User $user): Application
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProfiles(): ArrayCollection
    {
        return $this->profiles;
    }

    /**
     * @param ArrayCollection $profiles
     * @return Application
     */
    public function setProfiles(ArrayCollection $profiles): Application
    {
        $this->profiles = $profiles;
        return $this;
    }

    /**
     * @return DisplayPreset
     */
    public function getDisplayPreset(): ?DisplayPreset
    {
        return $this->displayPreset;
    }

    /**
     * @param DisplayPreset $displayPreset
     * @return Application
     */
    public function setDisplayPreset(DisplayPreset $displayPreset): Application
    {
        $this->displayPreset = $displayPreset;
        return $this;
    }

    /**
     * Add profile
     *
     * @param \App\Entity\Profile $profile
     *
     * @return Application
     */
    public function addProfile(Profile $profile)
    {
        $this->profiles[] = $profile;

        return $this;
    }

    /**
     * Remove profile
     *
     * @param \App\Entity\Profile $profile
     */
    public function removeProfile(Profile $profile)
    {
        $this->profiles->removeElement($profile);
    }
}
