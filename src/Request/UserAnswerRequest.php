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
        $this->answers = ArrayFieldDispatcher::dispatchField($json, 'choiceAnswers');
        $this->comments = ArrayFieldDispatcher::dispatchField($json, 'commentAnswers');
        $this->underEvaluation = ArrayFieldDispatcher::dispatchField($json, 'underEvaluation');
        var_dump($this->mapAnswersAndComments());
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

    private function mapAnswersAndComments()
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
        $clonedComments = $this->comments;
        foreach ($this->answers as $answer) {
            $criteria = array();
            $doBreak = false;

            foreach ($uniq as $id) {
                if ((int) $answer['criteriaId'] === $id) {
                    $criteria['criteriaId'] = (int) $id;
                    $criteria['choiceId'] = (int) $answer['choiceId'];
                    $doBreak = true;
                    break;
                }
            }
            foreach ($clonedComments as $comment) {
                foreach ($uniq as $id) {
                    if ((int) $comment['criteriaId'] === $id) {
                        $criteria['criteriaId'] === $id;
                        $criteria['comment'] = (string) $comment['comment'];
                        array_shift($clonedComments);
                        //array_shift($uniq);
                        $doBreak = true;
                        break;
                    }
                }
                if ($doBreak) {
                    break;
                }
            }
            $mapped[] = $criteria;
        }
        return $mapped;
    }
}
