<?php


namespace App\Request;

use App\Utils\ArrayFieldDispatcher;
use Symfony\Component\HttpFoundation\Request;

class ManagerFeedbackRequest
{

    /** @var bool|mixed  */
    private $formId;

    /** @var bool|mixed  */
    private $criteriaId;

    /** @var bool|mixed  */
    private $evaluation;

    /** @var bool|mixed  */
    private $comment;


    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->formId = ArrayFieldDispatcher::dispatchField($json, 'formId');
        $this->criteriaId =  ArrayFieldDispatcher::dispatchField($json, 'criteriaId');
        $this->evaluation =  ArrayFieldDispatcher::dispatchField($json, 'evaluation');
        $this->comment = ArrayFieldDispatcher::dispatchField($json, 'comment');
    }

    /**
     * @return bool|mixed
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * @return bool|mixed
     */
    public function getCriteriaId()
    {
        return $this->criteriaId;
    }

    /**
     * @return bool|mixed
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * @return bool|mixed
     */
    public function getComment()
    {
        return $this->comment;
    }
}
