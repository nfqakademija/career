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
    public $profileView;

    /** @var string */
    public $userFirstName;

    /** @var string */
    public $userLastName;

    /** @var Collection|UserAnswerView[] */
    public $userAnswerList;

}