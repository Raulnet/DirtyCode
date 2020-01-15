<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{
    /**
     * @Route("/switch-locale/{locale}", name="switch-locale")
     */
    public function index(Request $request, string $locale)
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirect($request->headers->get('referer'));
    }
}
