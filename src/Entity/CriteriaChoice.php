<?php

namespace App\Entity;

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
}
