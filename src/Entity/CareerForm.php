<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CareerFormRepository")
 */
class CareerForm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Occupation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkOccupation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkOccupation(): ?Occupation
    {
        return $this->fkOccupation;
    }

    public function setFkOccupation(Occupation $fkOccupation): self
    {
        $this->fkOccupation = $fkOccupation;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
