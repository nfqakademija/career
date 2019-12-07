<?php


namespace App\View;

use Doctrine\Common\Collections\Collection;

class FormView
{
    /**
     * @var int
     */
    public $id;

    /** @var datetime */
    public $createdAt;

    /**
     * @var ProfileView
     */
    public $profile;

    /**
     * @var UserView
     */
    public $userView;
    
}
