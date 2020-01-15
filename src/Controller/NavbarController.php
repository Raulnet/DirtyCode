<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavbarController extends AbstractController
{
    public function navbarUser(UserRepository $userRepository)
    {
        return $this->render('navbar/user_switch.html.twig', [
            'users' => $userRepository->findWithoutAdmin(),
        ]);
    }
}
