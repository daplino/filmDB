<?php

namespace App\Entity;

use App\Repository\ProductionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductionRepository::class)
 */
class Production
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class)
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="company", referencedColumnName="pic", nullable=false)
     * })
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
    * @ORM\ManyToOne(targetEntity=Work::class, inversedBy="id", cascade={"persist"})
    */
    private $work;

    /**
     * @ORM\Column(type="float")
     */
    private $share;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getShare(): ?float
    {
        return $this->share;
    }

    public function setShare(float $share): self
    {
        $this->share = $share;

        return $this;
    }

    public function getWork(): ?Work
    {
        return $this->work;
    }

    public function setWork(?Work $work): self
    {
        $this->work = $work;

        return $this;
    }
}
