<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee/", name="employee_homepage")
     */
    public function index()
    {
        return $this->render('home/employee.html.twig');
    }
}
