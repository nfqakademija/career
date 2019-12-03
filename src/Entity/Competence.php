<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 * @Table(name="competence",indexes={@Index(name="competence_idx", columns={"title", "is_applicable"})})
 */
class Competence
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
     * @ORM\OneToMany(targetEntity="App\Entity\Criteria", mappedBy="fkCompetence")
     */
    private $criterias;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isApplicable;

    public function __construct()
    {
        $this->criterias = new ArrayCollection();
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
     * @return Collection|Criteria[]
     */
    public function getCriterias(): Collection
    {
        return $this->criterias;
    }

    public function addCriteria(Criteria $criteria): self
    {
        if (!$this->criterias->contains($criteria)) {
            $this->criterias[] = $criteria;
            $criteria->setFkCompetence($this);
        }

        return $this;
    }

    public function removeCriteria(Criteria $criteria): self
    {
        if ($this->criterias->contains($criteria)) {
            $this->criterias->removeElement($criteria);
            // set the owning side to null (unless already changed)
            if ($criteria->getFkCompetence() === $this) {
                $criteria->setFkCompetence(null);
            }
        }

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
