<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\BaseController;
use App\Entity\Classroom;

class HomeController extends BaseController
{
    #[Route('/', name: 'app_home')]
    #[IsGranted("ROLE_USER")]
    public function index(EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }

        $classroom = $this->getUser()->getClasseID();

        if ($this->isGranted('ROLE_ADMIN')) {
            $classrooms = $em->getRepository(Classroom::class)->findAll();
        } else {
            $classrooms = $em->getRepository(Classroom::class)->findBy([
                'id' => $classroom->getId(),
            ]);
        }

        return $this->render('home/index.html.twig', [
            'classrooms' => $classrooms,
            'classroom' => $classroom,
        ]);
    }
}
