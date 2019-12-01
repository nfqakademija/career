<?php


namespace App\View;


use App\Entity\CareerForm;
use Doctrine\Common\Collections\Collection;

class UserView
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $professionTitle;

    /**
     * @var int
     */
    public $professionId;

    /**
     * @var array
     */
    public $roles;

    /**
     * @var array
     */
    public $teams;
}
