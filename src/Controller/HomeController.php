<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_homepage');
        } elseif ($this->isGranted('ROLE_EMPLOYEE')) {
            return $this->redirectToRoute('employee_homepage');
        } elseif ($this->isGranted('ROLE_HEAD')) {
            return $this->redirectToRoute('head_homepage');
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
