<?php


namespace App\Request;

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
        $this->professionId = $this->dispatchField($json, 'position');
        $this->competences = $this->dispatchField($json, 'competences');
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
