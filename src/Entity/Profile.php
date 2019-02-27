<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="sp_profile")
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
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
     * @ORM\Column(name="type", type="string", length=10)
     */
    private $type;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="json")
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * Many Profiles have One Application.
     * @ORM\ManyToOne(targetEntity="App\Entity\Application", inversedBy="profiles")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    private $application;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Profile
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set data
     *
     * @param array $data
     *
     * @return Profile
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Profile
     */
    public function setCreated(\DateTime $created): Profile
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getCreatedString($format = 'Y-m-d H:i:s'): string
    {
        if($this->created !== null){
            return $this->created->format($format);
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @param mixed $application
     * @return Profile
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;
        return $this;
    }
}
