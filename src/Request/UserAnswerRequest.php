<?php


namespace App\Request;

use App\Utils\ArrayFieldDispatcher;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class UserAnswerRequest
{
    /** @var int|null */
    private $formId;

    /** @var array  */
    private $answers;

    /** @var array  */
    private $comments;

    /** @var  bool|null */
    private $underEvaluation;

    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->formId = ArrayFieldDispatcher::dispatchField($json, 'formId') ?? null;
        $this->answers = ArrayFieldDispatcher::dispatchField($json, 'choiceAnswers') ?? array();
        $this->comments = ArrayFieldDispatcher::dispatchField($json, 'commentAnswers') ?? array();
        $this->underEvaluation = ArrayFieldDispatcher::dispatchField($json, 'underEvaluation') ?? null;
    }
    /**
     * @return int
     */
    public function getFormId()
    {
        return (int) $this->formId;
    }

    /**
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return bool|null
     */
    public function isUnderEvaluation()
    {
        return $this->underEvaluation;
    }
}
