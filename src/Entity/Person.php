<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
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
    private $work;

    /**
     * @ORM\OneToMany(targetEntity=Crew::class, mappedBy="person")
     */
    private $crewMember;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $residence;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    public function __construct()
    {
        $this->crewMember = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWork(): ?string
    {
        return $this->work;
    }

    public function setWork(string $work): self
    {
        $this->work = $work;

        return $this;
    }

    /**
     * @return Collection|Crew[]
     */
    public function getCrewMember(): Collection
    {
        return $this->crewMember;
    }

    public function addCrewMember(Crew $crewMember): self
    {
        if (!$this->crewMember->contains($crewMember)) {
            $this->crewMember[] = $crewMember;
            $crewMember->setPerson($this);
        }

        return $this;
    }

    public function removeCrewMember(Crew $crewMember): self
    {
        if ($this->crewMember->contains($crewMember)) {
            $this->crewMember->removeElement($crewMember);
            // set the owning side to null (unless already changed)
            if ($crewMember->getPerson() === $this) {
                $crewMember->setPerson(null);
            }
        }

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getResidence(): ?string
    {
        return $this->residence;
    }

    public function setResidence(string $residence): self
    {
        $this->residence = $residence;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}
