<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }

        return $this->render('profile/index.html.twig');
    }
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
