<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
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
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="team")
     */
    private $fkUser;

    public function __construct()
    {
        $this->fkUser = new ArrayCollection();
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
    public function getFkUser(): Collection
    {
        return $this->fkUser;
    }

    public function addFkUser(User $fkUser): self
    {
        if (!$this->fkUser->contains($fkUser)) {
            $this->fkUser[] = $fkUser;
        }

        return $this;
    }

    public function removeFkUser(User $fkUser): self
    {
        if ($this->fkUser->contains($fkUser)) {
            $this->fkUser->removeElement($fkUser);
        }

        return $this;
    }

}
