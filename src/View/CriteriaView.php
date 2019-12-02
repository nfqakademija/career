<?php


namespace App\View;

use App\Entity\CriteriaChoice;
use Doctrine\Common\Collections\Collection;

class CriteriaView
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var Collection|CriteriaChoice[]
     */
    public $choiceList;
}
