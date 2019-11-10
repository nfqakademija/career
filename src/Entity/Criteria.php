<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CriteriaRepository")
 */
class Criteria
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Competence", inversedBy="criterias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_competence;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isApplicable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CriteriaChoice", mappedBy="fk_criteria")
     */
    private $criteriaChoices;

    public function __construct()
    {
        $this->criteriaChoices = new ArrayCollection();
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

    public function getFkCompetence(): ?Competence
    {
        return $this->fk_competence;
    }

    public function setFkCompetence(?Competence $fk_competence): self
    {
        $this->fk_competence = $fk_competence;

        return $this;
    }

    public function getIsApplicable(): ?bool
    {
        return $this->isApplicable;
    }

    public function setIsApplicable(bool $isApplicable): self
    {
        $this->isApplicable = $isApplicable;

        return $this;
    }

    /**
     * @return Collection|CriteriaChoice[]
     */
    public function getCriteriaChoices(): Collection
    {
        return $this->criteriaChoices;
    }

    public function addCriteriaChoice(CriteriaChoice $criteriaChoice): self
    {
        if (!$this->criteriaChoices->contains($criteriaChoice)) {
            $this->criteriaChoices[] = $criteriaChoice;
            $criteriaChoice->setFkCriteria($this);
        }

        return $this;
    }

    public function removeCriteriaChoice(CriteriaChoice $criteriaChoice): self
    {
        if ($this->criteriaChoices->contains($criteriaChoice)) {
            $this->criteriaChoices->removeElement($criteriaChoice);
            // set the owning side to null (unless already changed)
            if ($criteriaChoice->getFkCriteria() === $this) {
                $criteriaChoice->setFkCriteria(null);
            }
        }

        return $this;
    }
}