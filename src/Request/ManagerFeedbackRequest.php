<?php


namespace App\Request;

use App\Utils\ArrayFieldDispatcher;
use Symfony\Component\HttpFoundation\Request;

class ManagerFeedbackRequest
{

    /** @var int|null  */
    private $formId;

    /** @var mixed  */
    private $evaluation;

    /** @var mixed  */
    private $comments;


    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->formId = ArrayFieldDispatcher::dispatchField($json, 'formId');
        $this->evaluation = ArrayFieldDispatcher::dispatchField($json, 'choiceAnswers') ?? array();
        $this->comments = ArrayFieldDispatcher::dispatchField($json, 'commentAnswers') ?? array();
    }

    /**
     * @return int
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * @return array
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * @return array
     */
    public function getComment()
    {
        return $this->comments;
    }
}
