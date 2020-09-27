<?php

namespace App\Entity;

use App\Repository\EventRepeatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepeatRepository::class)
 */
class EventRepeat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $repeatInterval;

    /**
     * @ORM\Column(type="integer")
     */
    private $frequency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepeatInterval(): ?int
    {
        return $this->repeatInterval;
    }

    public function setRepeatInterval(int $repeatInterval): self
    {
        $this->repeatInterval = $repeatInterval;

        return $this;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }
}
