<?php

namespace App\Entity;

use App\Repository\ProfilesRepository;
use App\Traits\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Profiles
{
    use TimeStampTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 50)]
    private $rs;

    #[ORM\OneToOne(mappedBy: 'profiles', targetEntity: Candidats::class, cascade: ['persist', 'remove'])]
    private $candidats;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getRs(): ?string
    {
        return $this->rs;
    }

    public function setRs(string $rs): self
    {
        $this->rs = $rs;

        return $this;
    }

    public function getCandidats(): ?Candidats
    {
        return $this->candidats;
    }

    public function setCandidats(?Candidats $candidats): self
    {
        // unset the owning side of the relation if necessary
        if ($candidats === null && $this->candidats !== null) {
            $this->candidats->setProfiles(null);
        }

        // set the owning side of the relation if necessary
        if ($candidats !== null && $candidats->getProfiles() !== $this) {
            $candidats->setProfiles($this);
        }

        $this->candidats = $candidats;

        return $this;
    }


    public function __toString():string
    {
        return $this->rs." ".$this->url;
    }

}
