<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Classroom;

class UserController extends BaseController
{
    #[Route('/profile', name: 'app_profile')]

    public function profile(EntityManagerInterface $em): Response
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

        return $this->render('profile/index.html.twig', [
            'classrooms' => $classrooms,
            'classroom' => $classroom,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
