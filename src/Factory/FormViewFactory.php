<?php


namespace App\Factory;

use App\Entity\CareerForm;
use App\View\FormView;
use App\View\ProfileView;

class FormViewFactory
{

    /**
     * @var CriteriaViewFactory
     */
    private $criteriaViewFactory;

    /** @var UserAnswerViewFactory */
    private $userAnswerViewFactory;

    /** @var ProfileViewFactory */
    private $profileViewFactory;

    public function __construct(
        CriteriaViewFactory $criteriaViewFactory,
        UserAnswerViewFactory $userAnswerViewFactory,
        ProfileViewFactory $profileViewFactory
    )
    {
        $this->profileViewFactory = $profileViewFactory;
        $this->userAnswerViewFactory = $userAnswerViewFactory;
        $this->criteriaViewFactory = $criteriaViewFactory;
    }

    public function create(CareerForm $form): FormView
    {
        /** @var FormView $formView */
        $formView = new FormView();
        $formView->id = $form->getId();
        $formView->createdAt = $form->getCreatedAt();
        $formView->profile = $this->profileViewFactory->create($form->getFkCareerProfile());
        $formView->userFirstName = $form->getFkUser()->getFirstName();
        $formView->userLastName = $form->getFkUser()->getLastName();

        foreach ($form->getUserAnswers() as $userAnswer) {
            $formView->userAnswerList[] = $this->userAnswerViewFactory->create($userAnswer);
        }

        return $formView;
    }


}