<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 */
class Employee
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
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", mappedBy="subordinates")
     */
    private $superiors;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", inversedBy="superiors")
     * @ORM\JoinTable(name="superior_subordinates")
     */
    private $subordinates;

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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Employee
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
     * @return Employee
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
     * Set email
     *
     * @param string $email
     *
     * @return Employee
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Getter for Superiors.
     *
     * @return mixed
     */
    public function getSuperiors()
    {
        return $this->superiors;
    }

    /**
     * Setter for Superiors.
     *
     * @param mixed $superiors
     *
     * @return $this
     */
    public function setSuperiors(mixed $superiors)
    {
        $this->superiors = $superiors;

        return $this;
    }

    /**
     * Getter for Subordinates.
     *
     * @return mixed
     */
    public function getSubordinates()
    {
        return $this->subordinates;
    }

    /**
     * Setter for Subordinates.
     *
     * @param mixed $subordinates
     *
     * @return $this
     */
    public function setSubordinates(mixed $subordinates)
    {
        $this->subordinates = $subordinates;

        return $this;
    }
}

