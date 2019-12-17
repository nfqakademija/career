<?php

namespace App\Request;

use App\Utils\ArrayFieldDispatcher;
use Symfony\Component\HttpFoundation\Request;

class CriteriaListRequest
{
    /** @var int|bool */
    private $competenceId;

    /** @var int|bool */
    private $criteriaId;

    /** @var string|bool */
    private $criteriaTitle;

    /** @var int|bool */
    private $choiceId;

    /** @var string|bool */
    private $choiceTitle;

    /** @var array|bool */
    private $choices;


    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->competenceId = ArrayFieldDispatcher::dispatchField($json, 'competence');
        $this->criteriaId = ArrayFieldDispatcher::dispatchField($json, 'criteriaId');
        $this->criteriaTitle = ArrayFieldDispatcher::dispatchField($json, 'criteriaTitle');
        $this->choiceId = ArrayFieldDispatcher::dispatchField($json, 'choiceId');
        $this->choiceTitle = ArrayFieldDispatcher::dispatchField($json, 'choiceTitle');
        $this->choices = ArrayFieldDispatcher::dispatchField($json, 'choices');
    }

    /**
     * @return bool|int
     */
    public function getCompetenceId()
    {
        return $this->competenceId;
    }

    /**
     * @return bool|int
     */
    public function getCriteriaId()
    {
        return $this->criteriaId;
    }

    /**
     * @return bool|string
     */
    public function getCriteriaTitle()
    {
        return $this->criteriaTitle;
    }

    /**
     * @return bool|int
     */
    public function getChoiceId()
    {
        return $this->choiceId;
    }

    /**
     * @return bool|string
     */
    public function getChoiceTitle()
    {
        return $this->choiceTitle;
    }



    /**
     * @return array|bool
     */
    public function getChoices()
    {
        return $this->choices;
    }

}
