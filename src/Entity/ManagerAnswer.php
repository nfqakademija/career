<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManagerAnswerRepository")
 */
class ManagerAnswer
{

    /** Timestampable trait */
    use Timestampable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserAnswer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkUserAnswer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValidAnswer;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $comment;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkUserAnswer(): ?UserAnswer
    {
        return $this->fkUserAnswer;
    }

    public function setFkUserAnswer(?UserAnswer $fkUserAnswer): self
    {
        $this->fkUserAnswer = $fkUserAnswer;

        return $this;
    }

    public function getIsValidAnswer(): ?bool
    {
        return $this->isValidAnswer;
    }

    public function setIsValidAnswer(?bool $isValidAnswer): self
    {
        $this->isValidAnswer = $isValidAnswer;

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
