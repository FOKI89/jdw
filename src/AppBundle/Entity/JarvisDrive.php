<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JarvisDrive
 *
 * @ORM\Table(name="jarvis_drive")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JarvisDriveRepository")
 */
class JarvisDrive
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
     * @var int
     *
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="currentSpace", type="integer")
     */
    private $currentSpace;


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
     * Set userId
     *
     * @param integer $userId
     *
     * @return JarvisDrive
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set currentSpace
     *
     * @param integer $currentSpace
     *
     * @return JarvisDrive
     */
    public function setCurrentSpace($currentSpace)
    {
        $this->currentSpace = $currentSpace;

        return $this;
    }

    /**
     * Get currentSpace
     *
     * @return int
     */
    public function getCurrentSpace()
    {
        return $this->currentSpace;
    }
}
