<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecurringEmployeeFeedback
 *
 * @ORM\Table(name="recurring_employee_feedback")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecurringEmployeeFeedbackRepository")
 */
class RecurringEmployeeFeedback
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
     * @var \DateTime
     *
     * @ORM\Column(name="target_date", type="datetime")
     */
    private $targetDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="appointed_date", type="datetime", nullable=true)
     */
    private $appointedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="protocol", type="text", nullable=true)
     */
    private $protocol;

    /**
     * @var string
     *
     * @ORM\Column(name="note_hr", type="text", nullable=true)
     */
    private $noteHr;

    /**
     * @var string
     *
     * @ORM\Column(name="note_superior", type="text", nullable=true)
     */
    private $noteSuperior;

    /**
     * @var string
     *
     * @ORM\Column(name="note_employee", type="text", nullable=true)
     */
    private $noteEmployee;

    /**
     * @var string
     *
     * @ORM\Column(name="type_of_meeting", type="string", length=255, nullable=true)
     */
    private $typeOfMeeting;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="id")
     */
    private $employee;

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
     * Set targetDate
     *
     * @param \DateTime $targetDate
     *
     * @return RecurringEmployeeFeedback
     */
    public function setTargetDate($targetDate)
    {
        $this->targetDate = $targetDate;

        return $this;
    }

    /**
     * Get targetDate
     *
     * @return \DateTime
     */
    public function getTargetDate()
    {
        return $this->targetDate;
    }

    /**
     * Set appointedDate
     *
     * @param \DateTime $appointedDate
     *
     * @return RecurringEmployeeFeedback
     */
    public function setAppointedDate($appointedDate)
    {
        $this->appointedDate = $appointedDate;

        return $this;
    }

    /**
     * Get appointedDate
     *
     * @return \DateTime
     */
    public function getAppointedDate()
    {
        return $this->appointedDate;
    }

    /**
     * Set protocolFile
     *
     * @param string $protocol
     *
     * @return RecurringEmployeeFeedback
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Get protocol text.
     *
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Set noteHr
     *
     * @param string $noteHr
     *
     * @return RecurringEmployeeFeedback
     */
    public function setNoteHr($noteHr)
    {
        $this->noteHr = $noteHr;

        return $this;
    }

    /**
     * Get noteHr
     *
     * @return string
     */
    public function getNoteHr()
    {
        return $this->noteHr;
    }

    /**
     * Set noteSuperior
     *
     * @param string $noteSuperior
     *
     * @return RecurringEmployeeFeedback
     */
    public function setNoteSuperior($noteSuperior)
    {
        $this->noteSuperior = $noteSuperior;

        return $this;
    }

    /**
     * Get noteSuperior
     *
     * @return string
     */
    public function getNoteSuperior()
    {
        return $this->noteSuperior;
    }

    /**
     * Set noteEmployee
     *
     * @param string $noteEmployee
     *
     * @return RecurringEmployeeFeedback
     */
    public function setNoteEmployee($noteEmployee)
    {
        $this->noteEmployee = $noteEmployee;

        return $this;
    }

    /**
     * Get noteEmployee
     *
     * @return string
     */
    public function getNoteEmployee()
    {
        return $this->noteEmployee;
    }

    /**
     * Set typeOfMeeting
     *
     * @param string $typeOfMeeting
     *
     * @return RecurringEmployeeFeedback
     */
    public function setTypeOfMeeting($typeOfMeeting)
    {
        $this->typeOfMeeting = $typeOfMeeting;

        return $this;
    }

    /**
     * Get typeOfMeeting
     *
     * @return string
     */
    public function getTypeOfMeeting()
    {
        return $this->typeOfMeeting;
    }

    /**
     * Set employee
     *
     * @param Employee $employee
     *
     * @return RecurringEmployeeFeedback
     */
    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) sprintf(
            'REF for %s targeted in month %s',
            $this->getEmployee(),
            $this->targetDate->format('M-Y')
        );
    }
}

