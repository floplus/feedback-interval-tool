<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var string
     *
     * @ORM\Column(name="slack_handle", type="string", length=255, nullable=true)
     */
    private $slackHandle;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", inversedBy="subordinates")
     * @ORM\JoinTable(
     *     name="superior_subordinates",
     *     joinColumns={@ORM\JoinColumn(name="employee_source", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="employee_target", referencedColumnName="id")}
     * )
     */
    private $superiors;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", mappedBy="superiors")
     */
    private $subordinates;

    /**
     * Getter for SlackHandle.
     *
     * @return string
     */
    public function getSlackHandle()
    {
        return $this->slackHandle;
    }

    /**
     * Setter for SlackHandle.
     *
     * @param string $slackHandle
     *
     * @return $this
     */
    public function setSlackHandle(string $slackHandle)
    {
        $this->slackHandle = $slackHandle;

        return $this;
    }


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
     * @return ArrayCollection[Employee]
     */
    public function getSuperiors()
    {
        return $this->superiors;
    }

    /**
     * Setter for Superiors.
     *
     * @param ArrayCollection[Employee] $superiors
     *
     * @return $this
     */
    public function setSuperiors(ArrayCollection $superiors)
    {
        $this->superiors = $superiors;

        return $this;
    }

    /**
     * Getter for Subordinates.
     *
     * @return ArrayCollection[Employee]
     */
    public function getSubordinates()
    {
        return $this->subordinates;
    }

    /**
     * Setter for Subordinates.
     *
     * @param ArrayCollection[Employee] $subordinates
     *
     * @return $this
     */
    public function setSubordinates(ArrayCollection $subordinates)
    {
        $this->subordinates = $subordinates;

        return $this;
    }

    /**
     * Return a simple String representation of an employee.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s %s (%s)", $this->getFirstName(), $this->getLastName(), $this->getEmail());

    }
}

