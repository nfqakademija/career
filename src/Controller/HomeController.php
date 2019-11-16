<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Annotation\Route;

// class HomeController extends AbstractController
// {
//     /**
//      * @Route("/", name="home")
//      */

//     public function index()
//     {
//         if ($this->isGranted('ROLE_ADMIN')) {
//             return $this->redirectToRoute('admin_homepage');
//         } elseif ($this->isGranted('ROLE_EMPLOYEE')) {
//             return $this->redirectToRoute('employee_homepage');
//         } elseif ($this->isGranted('ROLE_HEAD')) {
//             return $this->redirectToRoute('head_homepage');
//         } else {
//             return $this->redirectToRoute('fos_user_security_login');
//         }
//     }

// }

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends Controller
{
    /**
     * @Route("/{reactRouting}", name="index", defaults={"reactRouting": null})
     */
    public function dashboard(): Response
    {
        return $this->render('home/index.html.twig');
    }
}