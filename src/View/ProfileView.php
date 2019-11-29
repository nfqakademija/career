<?php


namespace App\View;


use App\Entity\Criteria;
use Doctrine\Common\Collections\Collection;

class ProfileView
{
    /**
     * @var int
     */
    public $id;

    /** @var string */
    public $professionTitle;

    /** @var Collection|Criteria[] */
    public $criteriaList;

}