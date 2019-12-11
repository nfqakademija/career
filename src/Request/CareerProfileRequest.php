<?php


namespace App\Request;

use App\Utils\ArrayFieldDispatcher;
use Symfony\Component\HttpFoundation\Request;

class CareerProfileRequest
{

    /** @var int|bool */
    private $professionId;

    /** @var array|bool */
    private $competences;

    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->professionId = ArrayFieldDispatcher::dispatchField($json, 'position');
        $this->competences = ArrayFieldDispatcher::dispatchField($json, 'competences');
    }

    /**
     * @return bool|int
     */
    public function getProfessionId()
    {
        return $this->professionId;
    }

    /**
     * @return array|bool
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     *
     */
    public function getCriteriaIds()
    {
        $criteriaLists = $this->dispatchField($this->competences, 'criteriaList');

        if (!$criteriaLists) {
            return false;
        }

        $criteriaIds = array();

        foreach ($criteriaLists as $list) {
            $criteriaIds[] = $this->dispatchField($list, 'id');
        }

        return $criteriaIds;
    }
}
