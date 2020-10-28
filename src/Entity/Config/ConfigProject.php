<?php

namespace App\Entity\Config;

use App\Repository\ConfigProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfigProjectRepository::class)
 */
class ConfigProject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activityType;

    /**
     * @ORM\Column(type="smallint")
     */
    private $minNbActivities;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maxNbActivites;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getActivityType(): ?string
    {
        return $this->activityType;
    }

    public function setActivityType(string $activityType): self
    {
        $this->activityType = $activityType;

        return $this;
    }

    public function getMinNbActivities(): ?int
    {
        return $this->minNbActivities;
    }

    public function setMinNbActivities(int $minNbActivities): self
    {
        $this->minNbActivities = $minNbActivities;

        return $this;
    }

    public function getMaxNbActivites(): ?int
    {
        return $this->maxNbActivites;
    }

    public function setMaxNbActivites(int $maxNbActivites): self
    {
        $this->maxNbActivites = $maxNbActivites;

        return $this;
    }
}
