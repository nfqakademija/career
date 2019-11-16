<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HeadController extends AbstractController
{
    /**
     * @Route("/head/", name="head_homepage")
     */
    public function index()
    {
        return $this->render('home/head.html.twig');
    }
}