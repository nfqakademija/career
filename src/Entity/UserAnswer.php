<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAnswerRepository")
 * @Table(name="user_answer",indexes={@Index(name="answer_idx", columns={"fk_career_form_id", "fk_criteria_id"})})
 */
class UserAnswer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Criteria", inversedBy="userAnswers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkCriteria;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CriteriaChoice", inversedBy="userAnswers")
     */
    private $fkChoice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CareerForm", inversedBy="userAnswers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkCareerForm;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkCriteria(): ?Criteria
    {
        return $this->fkCriteria;
    }

    public function setFkCriteria(Criteria $fkCriteria): self
    {
        $this->fkCriteria = $fkCriteria;

        return $this;
    }

    public function getFkChoice(): ?CriteriaChoice
    {
        return $this->fkChoice;
    }

    public function setFkChoice(?CriteriaChoice $fkChoice): self
    {
        $this->fkChoice = $fkChoice;

        return $this;
    }

    public function getFkCareerForm(): ?CareerForm
    {
        return $this->fkCareerForm;
    }

    public function setFkCareerForm(?CareerForm $fkCareerForm): self
    {
        $this->fkCareerForm = $fkCareerForm;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

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
