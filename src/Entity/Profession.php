<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfessionRepository")
 */
class Profession
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
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="profession")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CareerProfile", mappedBy="profession", cascade={"persist", "remove"})
     */
    private $careerProfile;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfession($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getProfession() === $this) {
                $user->setProfession(null);
            }
        }

        return $this;
    }

    public function getCareerProfile(): ?CareerProfile
    {
        return $this->careerProfile;
    }

    public function setCareerProfile(CareerProfile $careerProfile): self
    {
        $this->careerProfile = $careerProfile;

        // set the owning side of the relation if necessary
        if ($careerProfile->getProfession() !== $this) {
            $careerProfile->setProfession($this);
        }

        return $this;
    }
}
