<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenreRepository::class)
 */
class Genre
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Work::class)
     */
    private $work;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $workType;

    public function __construct()
    {
        $this->work = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Work[]
     */
    public function getWork(): Collection
    {
        return $this->work;
    }

    public function addWork(Work $work): self
    {
        if (!$this->work->contains($work)) {
            $this->work[] = $work;
        }

        return $this;
    }

    public function removeWork(Work $work): self
    {
        if ($this->work->contains($work)) {
            $this->work->removeElement($work);
        }

        return $this;
    }

    public function getWorkType(): ?string
    {
        return $this->workType;
    }

    public function setWorkType(string $workType): self
    {
        $this->workType = $workType;

        return $this;
    }
}
