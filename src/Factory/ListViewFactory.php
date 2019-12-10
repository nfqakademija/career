<?php


namespace App\Factory;

use ReflectionClass;

class ListViewFactory
{

    public static function create(Array $objects)
    {
        $list = array();
        $reflect = new ReflectionClass($objects[0]);
        $factoryName = $reflect->getShortName() . 'ViewFactory';
        require_once 'src/Factory/' . $factoryName . '.php';
        $factory = new $factoryName();
        foreach ($objects as $object) {
            $list[] = $factory->create($object);
        }
        return $list;
    }
}
