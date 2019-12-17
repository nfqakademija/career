<?php


namespace App\Factory;

use App\View\ListView;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ListViewFactory
{

    /** @var  string */
    private $viewFactory;

    /** @var ContainerInterface  */
    private $container;

    /**
     * ListViewFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $viewFactory
     * @return $this
     */
    public function setViewFactory(string $viewFactory)
    {
        $this->viewFactory = $viewFactory;
        return $this;
    }

    /**
     * Create view for list of objects provided
     * NOTE: Not applicable for managerAnswerListView and userAnswerListView
     * @param array $objects
     * @return ListView
     */
    public function create(Array $objects)
    {
        $listView = new ListView();

        foreach ($objects as $object) {
            $listView->list[] = $this->container->get($this->viewFactory)->create($object);
        }
        return $listView;
    }
}
