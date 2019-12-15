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

    /**
     * Returns choice ids mapped with comments under single criteria Id
     * Use this method when comments and answers/evaluation arrays are not aligned under a single criteriaId in a
     * JSON passed.
     * @return array
     */
    public function getMapEvaluationAndComments()
    {
        $answerCriteria = array();
        foreach ($this->evaluation as $answer) {
            $answerCriteria[] = (int) ArrayFieldDispatcher::dispatchField($answer, 'answerId');
        }

        foreach ($this->comments as $comment) {
            $answerCriteria[] = (int) ArrayFieldDispatcher::dispatchField($comment, 'answerId');
        }

        $uniq= array_unique($answerCriteria, SORT_NUMERIC);
        asort($uniq);

        $mapped = array();
        foreach ($uniq as $id) {
            $criteria = array();
            foreach ($this->evaluation as $answer) {
                if ((int) $answer['answerId'] === $id) {
                    $criteria['answerId'] = (int) $id;
                    $criteria['choiceId'] = (bool) $answer['choiceId'];
                    $criteria['comment'] = null;
                    break;
                }
            }
            foreach ($this->comments as $comment) {
                if ((int)$comment['answerId'] === $id) {
                    $criteria['answerId'] = (int) $id;
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
