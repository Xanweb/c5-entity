<?php

namespace Xanweb\C5\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TimeStampableTrait
 * *** IMPORTANT !!! *****
 * Please note that usage of this trait requires "HasLifecycleCallbacks" annotation.
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/annotations-reference.html#annref_haslifecyclecallbacks
 */
trait TimeStampableTrait
{
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var DateTimeInterface
     */
    protected $updatedAt;

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreated(): void
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdated(): void
    {
        $this->updatedAt = new DateTime();
    }
}
