<?php


namespace App\Factory;

use App\Entity\CareerForm;
use App\View\FormView;

class FormViewFactory
{

    /**
     * @var CriteriaViewFactory
     */
    private $criteriaViewFactory;

    /** @var UseriewFactory */
    private $userViewFactory;

    /** @var ProfileViewFactory */
    private $profileViewFactory;

    public function __construct(
        CriteriaViewFactory $criteriaViewFactory,
        UserViewFactory $userViewFactory,
        ProfileViewFactory $profileViewFactory
    ) {
        $this->profileViewFactory = $profileViewFactory;
        $this->userViewFactory = $userViewFactory;
        $this->criteriaViewFactory = $criteriaViewFactory;
    }

    public function create(CareerForm $form): FormView
    {
        /** @var FormView $formView */
        $formView = new FormView();
        $formView->id = $form->getId();
        $formView->createdAt = $form->getCreatedAt();
        $formView->profile = $this->profileViewFactory->create($form->getFkCareerProfile());
        $formView->userView = $this->userViewFactory->create($form->getFkUser());

        return $formView;
    }
}
