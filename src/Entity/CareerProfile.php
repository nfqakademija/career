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
}
