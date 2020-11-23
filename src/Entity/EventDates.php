<?php

namespace App\Entity;

use App\Repository\EventDatesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventDatesRepository::class)
 */
class EventDates
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $eventDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startingTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endingTime;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $allday;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="eventDates")
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getStartingTime()
    {
        return $this->startingTime;
    }

    public function setStartingTime( $startingTime): self
    {
        $this->startingTime = $startingTime;

        return $this;
    }

    public function getEndingTime()
    {
        return $this->endingTime;
    }

    public function setEndingTime( $endingTime): self
    {
        $this->endingTime = $endingTime;

        return $this;
    }

    public function getAllday(): ?bool
    {
        return $this->allday;
    }

    public function setAllday(?bool $allday): self
    {
        $this->allday = $allday;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
