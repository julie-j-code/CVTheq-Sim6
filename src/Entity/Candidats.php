<?php

namespace App\Entity;

use App\Repository\CandidatsRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CandidatsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Candidats
{
    
    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 150)]
    private $lastname;

    #[ORM\Column(type: 'smallint')]
    private $age;

    #[ORM\OneToOne(inversedBy: 'candidats', targetEntity: Profiles::class, cascade: ['persist', 'remove'])]
    private $profiles;

    #[ORM\ManyToMany(targetEntity: Hobbies::class)]
    private $hobbies;

    #[ORM\ManyToOne(targetEntity: Jobs::class, inversedBy: 'candidats')]
    private $jobs;

    #[ORM\Column(type: 'string', length:255, nullable:true)]
    private $pictureFilename;

    // createdAt et updatedAt sont désormais dans Traits

    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getProfiles(): ?Profiles
    {
        return $this->profiles;
    }

    public function setProfiles(?Profiles $profiles): self
    {
        $this->profiles = $profiles;

        return $this;
    }

    /**
     * @return Collection<int, Hobbies>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobbies $hobby): self
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies[] = $hobby;
        }

        return $this;
    }

    public function removeHobby(Hobbies $hobby): self
    {
        $this->hobbies->removeElement($hobby);

        return $this;
    }

    public function getJobs(): ?Jobs
    {
        return $this->jobs;
    }

    public function setJobs(?Jobs $jobs): self
    {
        $this->jobs = $jobs;

        return $this;
    }

    public function getPictureFilename()
    {
        return $this->pictureFilename;
    }

    public function setPictureFilename($pictureFilename)
    {
        $this->pictureFilename = $pictureFilename;

        return $this;
    }

    // les getter et setter de createdAt et updatedAt sont desormais dans Traits avec PrePersist et PreUpdated

}
