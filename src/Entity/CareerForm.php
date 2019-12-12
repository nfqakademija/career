<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CareerProfile", inversedBy="careerForms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkCareerProfile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAnswer", mappedBy="fkCareerForm")
     */
    private $userAnswers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="careerForm", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkUser;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isArchived;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $underEvaluation;

    public function __construct()
    {
        $this->userAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFkCareerProfile(): ?CareerProfile
    {
        return $this->fkCareerProfile;
    }

    public function setFkCareerProfile(?CareerProfile $fkCareerProfile): self
    {
        $this->fkCareerProfile = $fkCareerProfile;

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

    public function getFkUser(): ?User
    {
        return $this->fkUser;
    }

    public function setFkUser(User $fkUser): self
    {
        $this->fkUser = $fkUser;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUnderEvaluation(): ?bool
    {
        return $this->underEvaluation;
    }

    public function setUnderEvaluation(bool $underEvaluation): self
    {
        $this->underEvaluation = $underEvaluation;

        return $this;
    }
}
