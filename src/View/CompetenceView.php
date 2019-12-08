<?php


namespace App\View;

use App\Entity\Criteria;
use Doctrine\Common\Collections\Collection;

class CompetenceView
{
    /** @var int */
    public $id;

    /** @var string */
    public $title;

    /** @var Collection|Criteria[] */
    public $criteriaList;
}
