<?php


namespace App\Factory;


use App\View\FormListView;

class FormListViewFactory
{
    /** @var FormViewFactory */
    private $formViewFactory;

    public function __construct(FormViewFactory $formViewFactory)
    {
        $this->formViewFactory = $formViewFactory;
    }

    public function create(Array $forms): FormListView
    {
        /** @var FormListView $formListView */
        $formListView = new FormListView();
        foreach ($forms as $form) {
            $formView = $this->formViewFactory->create($form);
            $formListView->list[] = $formView;
        }

        return $formListView;
    }

}