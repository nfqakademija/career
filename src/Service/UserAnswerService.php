<?php


namespace App\Service;

use App\Entity\CareerForm;
use App\Entity\UserAnswer;
use App\Repository\CareerFormRepository;
use App\Repository\CriteriaRepository;
use App\Repository\UserAnswerRepository;
use Symfony\Component\HttpFoundation\Request;

class UserAnswerService
{

    /** @var UserAnswerRepository */
    private $userAnswerRepository;

    /** @var CareerFormRepository */
    private $careerFormRepository;

    /** @var CriteriaRepository */
    private $criteriaRepository;

    public function __construct(
        CriteriaRepository $criteriaRepository,
        UserAnswerRepository $userAnswerRepository,
        CareerFormRepository $careerFormRepository
    ) {
        $this->criteriaRepository = $criteriaRepository;
        $this->userAnswerRepository = $userAnswerRepository;
        $this->careerFormRepository = $careerFormRepository;
    }

    public function saveUserChoices(Array $criteriaChoices, CareerForm $form)
    {
        foreach ($criteriaChoices as $choice) {
            $answered = $this->userAnswerRepository->findOneBy([
                'fkCareerForm' => $form,
                'fkCriteria' => $choice->getFkCriteria()]);

            if ($answered) {
                $answered->setFkChoice($choice);
                $answered->setUpdatedAt(new \DateTime("now"));
            }
            $userAnswer = ($answered) ? $answered : new UserAnswer();

            if (!$userAnswer->getId()) {
                $userAnswer->setCreatedAt(new \DateTime("now"));
            }
            $userAnswer->setFkChoice($choice);
            $userAnswer->setFkCriteria($choice->getFkCriteria());

            $this->userAnswerRepository->save($userAnswer);
            $userAnswer->setFkCareerForm($form);
            $form->addUserAnswer($userAnswer);
        }
        $this->careerFormRepository->save($form);
    }

    public function saveUserComments(Array $comments, CareerForm $form)
    {
        foreach ($comments as $key => $comment) {
            $criteriaId = (array_key_exists('criteriaId', $comment)) ? (int)$comment['criteriaId'] : null;
            $criteria = $this->criteriaRepository->findOneBy(['id' => $criteriaId]);
            $text = (array_key_exists('comment', $comment)) ? (string)$comment['comment'] : null;
            $answered = $this->userAnswerRepository->findOneBy([
                'fkCriteria' => $criteriaId,
                'fkCareerForm' => $form]);
            if ($answered) {
                $answered->setComment($text);
                $answered->setUpdatedAt(new \DateTime("now"));
            }
            $userAnswer = ($answered) ? $answered : new UserAnswer();

            if (!$userAnswer->getId()) {
                $userAnswer->setCreatedAt(new \DateTime("now"));
            }
            $userAnswer->setComment($text);
            $userAnswer->setFkCriteria($criteria);
            $this->userAnswerRepository->save($userAnswer);
            $form->addUserAnswer($userAnswer);
        }
        $this->careerFormRepository->save($form);
    }

    public function dispatchJson(Request $request, $fields = array())
    {
        // Fetch data from JSON
        $json = (array)json_decode(((string)$request->getContent()), true);
        if (!$json) {
            return false;
        }

        $data = $json['data'] ?? $json;

        $values = array();
        foreach ($fields as $field) {
            $values[$field] = $data[$field]?? null;
        }
        return $values;
    }

    public function extractIds($array, $idNeedle)
    {
        $idArray = array();
        foreach ($array as $i => $item) {
            foreach ($item as $key => $value) {
                if ($key === $idNeedle) {
                    $idArray[] = (int)$value;
                }
            }
        }
        return $idArray;
    }
}
