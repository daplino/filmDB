<?php

namespace App\Entity;

use App\Repository\WorkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Crew;

/**
 * @ORM\Entity(repositoryClass=WorkRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "film" = "Film",
 *      "videoGame" = "VideoGame"
 * })
 */
abstract Class Work
{
    /**
     * @ORM\Id()
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
    protected $YearOfCopyright;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Crew", mappedBy="work", cascade={"persist"})
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

    public function setId(string $id): self
    {
        $this->id = $id;

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

    
    public function getCrew()
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

    public function removeCrew(Crew $crew): self
    {
        if ($this->crew->contains($crew)) {
            $this->crew->removeElement($crew);
            // set the owning side to null (unless already changed)
            if ($crew->getWork() === $this) {
                $crew->setWork(null);
            }
        }

        return $this;
    }

    public function getType()
{
    $type = explode('\\', get_class($this));

    return end($type);
}

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }
    
}
