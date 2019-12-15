<?php


namespace App\Request;

use App\Utils\ArrayFieldDispatcher;
use Symfony\Component\HttpFoundation\Request;

class UserAnswerRequest
{
    /** @var int|null */
    private $formId;

    /** @var bool|array  */
    private $answers;

    /** @var bool|array  */
    private $comments;

    /** @var  bool|null*/
    private $underEvaluation;

    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->formId = ArrayFieldDispatcher::dispatchField($json, 'formId') ?? null;
        $this->answers = ArrayFieldDispatcher::dispatchField($json, 'choiceAnswers') ?? array();
        $this->comments = ArrayFieldDispatcher::dispatchField($json, 'commentAnswers') ?? array();
        $this->underEvaluation = ArrayFieldDispatcher::dispatchField($json, 'underEvaluation');
    }
    /**
     * @return int
     */
    public function getFormId()
    {
        return (int) $this->formId;
    }

    /**
     * @return bool|mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @return bool|mixed
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

    /**
     * @return array
     */
    public function getChoiceIds()
    {
        if (!$this->answers) {
            return false;
        }

        $choiceIds = array();
        foreach ($this->answers as $answer) {
            $choiceIds[] = (int) ArrayFieldDispatcher::dispatchField($answer, 'choiceId');
        }
        return $choiceIds;
    }
}
