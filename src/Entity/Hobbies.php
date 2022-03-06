<?php

namespace App\Entity;

use App\Repository\HobbiesRepository;
use App\Traits\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HobbiesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Hobbies
{
    use TimeStampTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $designation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function __toString():string
    {
        return $this->designation;
    }
}
