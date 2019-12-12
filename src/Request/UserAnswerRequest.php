<?php


namespace App\Request;

use App\Utils\ArrayFieldDispatcher;
use Symfony\Component\HttpFoundation\Request;

class UserAnswerRequest
{
    /** @var bool|int */
    private $formId;

    /** @var bool|array  */
    private $answers;

    /** @var bool|array  */
    private $comments;

    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->formId = ArrayFieldDispatcher::dispatchField($json, 'formId');
        $this->answers = ArrayFieldDispatcher::dispatchField($json, 'choiceAnswers');
        $this->comments = ArrayFieldDispatcher::dispatchField($json, 'commentAnswers');
    }
    /**
     * @return bool|mixed
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
