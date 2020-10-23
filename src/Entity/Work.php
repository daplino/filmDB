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
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $yearOfCopyright;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Crew", mappedBy="work", cascade={"persist"})
     */
    private $crew;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class)
     */
    private $genres;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Audience", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="audience", referencedColumnName="id")
     * })
     */
    private $audience;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Production", mappedBy="work", cascade={"persist"})
     */
    private $production;

    public function __construct()
    {
        $this->crew = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->production = new ArrayCollection();
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
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getYearOfCopyright(): ?string
    {
        return $this->yearOfCopyright;
    }

    public function setYearOfCopyright(?string $yearOfCopyright): self
    {
        $this->yearOfCopyright = $yearOfCopyright;

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
        if (!$this->crew->contains($crew)) {
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

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
        }

        return $this;
    }

    public function getAudience(): ?Audience
    {
        return $this->audience;
    }

    public function setAudience(?Audience $audience): self
    {
        $this->audience = $audience;

        return $this;
    }

    /**
     * @return Collection|Production[]
     */
    public function getProduction(): Collection
    {
        return $this->production;
    }

    public function addProduction(Production $production): self
    {
        if (!$this->production->contains($production)) {
            $this->production[] = $production;
            $production->setWork($this);
        }

        return $this;
    }

    public function removeProduction(Production $production): self
    {
        if ($this->production->contains($production)) {
            $this->production->removeElement($production);
            // set the owning side to null (unless already changed)
            if ($production->getWork() === $this) {
                $production->setWork(null);
            }
        }

        return $this;
    }
    public function getDirector()
    {
      $director = "";  
        foreach($this->crew as $row)
        {
            if($row->getRole()->getId() == 1 )
            {
                $director .=  $row->getPerson()->getFirstname();
                $director .=  " " . $row->getPerson()->getLastname()."\n \r";
            }
        }
        return $director;
    }
}
