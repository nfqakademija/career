<?php


namespace App\Request;

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
        $this->formId = $this->dispatchField($json, 'formId');
        $this->answers = $this->dispatchField($json, 'choiceAnswers');
        $this->comments = $this->dispatchField($json, 'commentAnswers');
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
            $choiceIds[] = (int) $this->dispatchField($answer, 'choiceId');
        }
        return $choiceIds;
    }

    /**
     * Helper
     * @param $array
     * @param $fieldName
     * @return bool|mixed
     */
    private function dispatchField($array, $fieldName)
    {
        foreach ($array as $key => $value) {
            if ($key === $fieldName) {
                return $value;
            }
            if (is_array($value)) {
                if ($result = $this->dispatchField($value, $fieldName)) {
                    return $result;
                }
            }
        }
        return false;
    }
}
