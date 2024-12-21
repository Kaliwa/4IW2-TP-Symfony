<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\BaseController;

class HomeController extends BaseController
{
    #[Route('/', name: 'app_home')]
    #[IsGranted("ROLE_USER")]
    public function index(EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }

        // $user = new \App\Entity\User();
        // $user->setFirstName(firstname: "john");
        // $user->setLastName("doe");
        // $user->setUsername("john_doe");
        // $user->setEmail("john@doe.com");
        // $user->setRoles(["ROLE_USER"]);
        // $user->setPassword($hasher->hashPassword($user, "j"));
        // $em->persist($user);
        // $em->flush();
        return $this->render(view: 'home/index.html.twig');
    }
}
