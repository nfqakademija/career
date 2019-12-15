<?php


namespace App\Request;

use App\Utils\ArrayFieldDispatcher;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class CareerProfileRequest
{

    /** @var int|null */
    private $professionId;

    /** @var array */
    private $competences;

    /**
     * CareerProfileRequest constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $json = (array)json_decode(((string)$request->getContent()), true);
        $this->professionId = ArrayFieldDispatcher::dispatchField($json, 'position') ?? null;
        $this->competences = ArrayFieldDispatcher::dispatchField($json, 'competences') ?? array();
    }

    /**
     * @return int
     */
    public function getProfessionId()
    {
        return (int) $this->professionId;
    }

    /**
     * @return array
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Gather all criteria Ids throughout all competences provided
     * @return array|null
     * @throws Exception
     */
    public function getCriteriaIds()
    {
        $criteriaLists = array();
        foreach ($this->competences as $competence) {
            $criteriaLists[] = ArrayFieldDispatcher::dispatchField($competence, 'criteriaList');
        }

        if (!$criteriaLists) {
            return false;
        }

        $criteriaIds = array();

        foreach ($criteriaLists as $list) {
            foreach ($list as $key => $value) {
                $criteriaIds[] = (int) ArrayFieldDispatcher::dispatchField($value, 'id');
            }
        }

        return $criteriaIds;
    }
}
