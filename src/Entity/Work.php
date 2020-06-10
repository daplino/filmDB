<?php

namespace App\Entity;

use App\Repository\WorkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkRepository::class)
 */
class Work
{
    /**
     * @ORM\id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $YearOfCopyright;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $Id): self
    {
        $this->Id = $Id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getYearOfCopyright(): ?string
    {
        return $this->YearOfCopyright;
    }

    public function setYearOfCopyright(string $YearOfCopyright): self
    {
        $this->YearOfCopyright = $YearOfCopyright;

        return $this;
    }
}
