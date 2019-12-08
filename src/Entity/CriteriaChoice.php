<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CriteriaChoiceRepository")
 */
class CriteriaChoice
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Criteria", inversedBy="criteriaChoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkCriteria;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isApplicable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAnswer", mappedBy="fkCareerForm")
     */
    private $userAnswers;

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

    public function getFkCriteria(): ?Criteria
    {
        return $this->fkCriteria;
    }

    public function setFkCriteria(?Criteria $fkCriteria): self
    {
        $this->fkCriteria = $fkCriteria;

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
     * @return Collection|UserAnswer[]
     */
    public function getUserAnswers(): Collection
    {
        return $this->userAnswers;
    }

    public function addUserAnswer(UserAnswer $userAnswer): self
    {
        if (!$this->userAnswers->contains($userAnswer)) {
            $this->userAnswers[] = $userAnswer;
            $userAnswer->setFkCareerForm($this);
        }

        return $this;
    }

    public function removeUserAnswer(UserAnswer $userAnswer): self
    {
        if ($this->userAnswers->contains($userAnswer)) {
            $this->userAnswers->removeElement($userAnswer);
            // set the owning side to null (unless already changed)
            if ($userAnswer->getFkCareerForm() === $this) {
                $userAnswer->setFkCareerForm(null);
            }
        }

        return $this;
    }
}
