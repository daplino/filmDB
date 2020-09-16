<?php

namespace App\Entity;

use App\Repository\CrewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CrewRepository::class)
 */
class Crew
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
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="crewMember")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Work", inversedBy="crew",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $work;

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
    private $points;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    
    public function getWork(): ?Work
    {
        return $this->work;
    }

    public function setWork(Work $work): self
    {
        $this->work = $work;

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

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(string $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
