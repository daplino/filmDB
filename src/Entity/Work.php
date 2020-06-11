<?php

namespace App\Entity;

use App\Repository\WorkRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Crew;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Crew", mappedBy="work")
     */
    private $crew;

    public function __construct()
    {
        $this->crew = new ArrayCollection();
    }

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

    /**
     * @return Collection|Crew[]
     */
    public function getCrew(): Collection
    {
        return $this->crew;
    }

    public function addCrew(Crew $crew): self
    {
        if(!$this->crew->contains($crew)){
            $this->crew[] = $crew;
            $crew->setWork($this);
        }

        return $this;
    }
    
}
