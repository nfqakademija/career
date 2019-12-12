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

    /** @var  bool*/
    private $underEvaluation;

    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->formId = ArrayFieldDispatcher::dispatchField($json, 'formId');
        $this->answers = ArrayFieldDispatcher::dispatchField($json, 'choiceAnswers') ?? array();
        $this->comments = ArrayFieldDispatcher::dispatchField($json, 'commentAnswers') ?? array();
        $this->underEvaluation = ArrayFieldDispatcher::dispatchField($json, 'underEvaluation');
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
     * @return bool
     */
    public function isUnderEvaluation(): bool
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

    /**
     * Returns choice ids mapped with comments under single criteria Id
     * @return array
     */
    public function getMapAnswersAndComments()
    {
        $answerCriteria = array();
        foreach ($this->answers as $answer) {
            $answerCriteria[] = (int) ArrayFieldDispatcher::dispatchField($answer, 'criteriaId');
        }

        foreach ($this->comments as $comment) {
            $answerCriteria[] = (int) ArrayFieldDispatcher::dispatchField($comment, 'criteriaId');
        }

        $uniq= array_unique($answerCriteria, SORT_NUMERIC);
        asort($uniq);

        $mapped = array();
        foreach ($uniq as $id) {
            $criteria = array();
            foreach ($this->answers as $answer) {
                if ((int) $answer['criteriaId'] === $id) {
                    $criteria['criteriaId'] = (int) $id;
                    $criteria['choiceId'] = (int) $answer['choiceId'];
                    $criteria['comment'] = null;
                    break;
                }
            }
            foreach ($this->comments as $comment) {
                if ((int)$comment['criteriaId'] === $id) {
                    $criteria['criteriaId'] = (int) $id;
                    $criteria['choiceId'] = $criteria['choiceId'] ?? null;
                    $criteria['comment'] = (string) $comment['comment'];
                    break;
                }
            }
            $mapped[] = $criteria;
        }

        return $mapped;
    }
}
