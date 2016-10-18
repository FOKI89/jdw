<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 * @ORM\Entity
 * @ORM\Table(name="contacts")
 */
class Contact
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $userId;

    /**
     * @ORM\Column(name="first_name", type="string", length=100)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=100)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="title_id", type="integer")
     */
    protected $titleId;

    /**
     * @ORM\Column(name="gender", type="smallint")
     */
    protected $gender;

    /**
     * @ORM\Column(name="country", type="string")
     */
    protected $country;

    /**
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(name="postal_code", type="string", nullable=true)
     */
    protected $postalCode;
    
    /**
     * Get id
     *
     * @return integer
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
     * @return Contact
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Contact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return Contact
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Contact
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Contact
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Contact
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set titleId
     *
     * @param integer $titleId
     *
     * @return Contact
     */
    public function setTitleId($titleId)
    {
        $this->titleId = $titleId;

        return $this;
    }

    /**
     * Get titleId
     *
     * @return integer
     */
    public function getTitleId()
    {
        return $this->titleId;
    }
}
