<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAnswerRepository")
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
     * @ORM\OneToOne(targetEntity="App\Entity\Criteria", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkCriteria;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CriteriaChoice", cascade={"persist", "remove"})
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
}
