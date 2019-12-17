<?php


namespace App\Utils;

class ArrayFieldDispatcher
{

    /**
     * Search for a given key=>value in an array
     * This function is used to fetch a single key=>value pair from an array
     *
     * @param array $array
     * @param string $fieldName
     * @return bool|mixed
     */
    public static function dispatchField(array $array, string $fieldName)
    {
        foreach ($array as $key => $value) {
            if ($key === $fieldName) {
                return $value;
            }
            if (is_array($value)) {
                if ($result = ArrayFieldDispatcher::dispatchField($value, $fieldName)) {
                    return $result;
                }
            }
        }
        return null;
    }

    /**
     * Maps values of two answer and comment arrays by their common attribute.
     * This function is JSON structure-specific (when decoded). It is used due to answer and comment arrays passed apart
     * from each other rather than tied together under a single criteria id in a single JSON.
     * This function can be ignored if JSON is passed in more suitable structure.
     *
     * @param array $arrayOne
     * @param array $arrayTwo
     * @param string $idx
     * @param string $keyInArrayOne
     * @param string $keyInArrayTwo
     * @return array
     */
    public static function mapArraysByCommonIdx(
        array $arrayOne,
        array $arrayTwo,
        string $idx,
        string $keyInArrayOne,
        string $keyInArrayTwo
    ) {

        $idxs = array();
        foreach ($arrayOne as $item) {
            $idxs[] = (int) ArrayFieldDispatcher::dispatchField($item, $idx);
        }

        foreach ($arrayTwo as $item) {
            $idxs[] = (int) ArrayFieldDispatcher::dispatchField($item, $idx);
        }

        $unique = array_unique($idxs, SORT_NUMERIC);
        asort($unique);

        $mapped = array();
        foreach ($unique as $id) {
            $mappedItem = array();
            foreach ($arrayOne as $item) {
                if ((int) $item[$idx] === $id) {
                    $mappedItem[$idx] = (int) $id;
                    $mappedItem[$keyInArrayOne] = (int) $item[$keyInArrayOne];
                    $mappedItem[$keyInArrayTwo] = null;
                    break;
                }
            }
            foreach ($arrayTwo as $item) {
                if ((int)$item[$idx] === $id) {
                    $mappedItem[$idx] = (int) $id;
                    $mappedItem[$keyInArrayOne] = $mappedItem[$keyInArrayOne] ?? null;
                    $mappedItem[$keyInArrayTwo] = (string) $item[$keyInArrayTwo];
                    break;
                }
            }
            $mapped[] = $mappedItem;
        }

        return $mapped;
    }
}
