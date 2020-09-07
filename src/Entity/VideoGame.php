<?php

namespace App\Entity;

use App\Repository\VideoGameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoGameRepository::class)
 */
class VideoGame Extends Work
{
  /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $test;

    public function getTest(): ?int
    {
        return $this->test;
    }

    public function setTest(?int $test): self
    {
        $this->test = $test;

        return $this;
    }  
}
