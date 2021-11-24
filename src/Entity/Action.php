<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 */
class Action
{
 
    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="action")
     * @ORM\Id
     * @ORM\Column(type="string", length=25)
     */
    private $code;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }



    public function __tostring(): ?string
    {
        return $this->code;
    }
}
