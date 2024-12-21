<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    public function checkAccess(): ?Response
    {
        if ($this->getUser() && in_array('ROLE_BANNED', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_banned');
        }
        return null;
    }

    #[Route('/banned', name: 'app_banned')]
    public function banned(): Response
    {
        $this->addFlash('error', 'Votre compte est banni. Contactez un administrateur.');
        return $this->render('home/banned.html.twig');
    }
}
