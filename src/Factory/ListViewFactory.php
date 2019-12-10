<?php


namespace App\Factory;

use App\View\ListView;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ListViewFactory
{

    private $viewFactory;
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setViewFactory(string $viewFactory)
    {
        $this->viewFactory = $viewFactory;
        return $this;
    }

    public function create(Array $objects)
    {
        $listView = new ListView();

        foreach ($objects as $object) {
            $listView->list[] = $this->container->get($this->viewFactory)->create($object);
        }
        return $listView;
    }
}
