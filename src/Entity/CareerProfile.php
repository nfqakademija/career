<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CareerProfileRepository")
 */
class CareerProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Criteria", inversedBy="careerProfiles")
     */
    private $fkCriteria;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CareerForm", mappedBy="fkCareerProfile", orphanRemoval=true)
     */
    private $careerForms;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profession", inversedBy="careerProfile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $profession;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isArchived;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->fkCriteria = new ArrayCollection();
        $this->careerForms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Criteria[]
     */
    public function getFkCriteria(): Collection
    {
        return $this->fkCriteria;
    }

    public function addFkCriterion(Criteria $fkCriterion): self
    {
        if (!$this->fkCriteria->contains($fkCriterion)) {
            $this->fkCriteria[] = $fkCriterion;
        }

        return $this;
    }

    public function removeFkCriterion(Criteria $fkCriterion): self
    {
        if ($this->fkCriteria->contains($fkCriterion)) {
            $this->fkCriteria->removeElement($fkCriterion);
        }

        return $this;
    }

    /**
     * @return Collection|CareerForm[]
     */
    public function getCareerForms(): Collection
    {
        return $this->careerForms;
    }

    public function addCareerForm(CareerForm $careerForm): self
    {
        if (!$this->careerForms->contains($careerForm)) {
            $this->careerForms[] = $careerForm;
            $careerForm->setFkCareerProfile($this);
        }

        return $this;
    }

    public function removeCareerForm(CareerForm $careerForm): self
    {
        if ($this->careerForms->contains($careerForm)) {
            $this->careerForms->removeElement($careerForm);
            // set the owning side to null (unless already changed)
            if ($careerForm->getFkCareerProfile() === $this) {
                $careerForm->setFkCareerProfile(null);
            }
        }

        return $this;
    }

    public function getProfession(): ?Profession
    {
        return $this->profession;
    }

    public function setProfession(Profession $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): self
    {
        $this->isArchived = $isArchived;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
