<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\ExerciseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ExerciseController extends AbstractController
{
    #[Route('/exercise', name: 'exercise_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $exercises = $em->getRepository(Exercise::class)->findAll();
        return $this->render('exercise/list.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/exercise/{id}', name: 'exercise_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $exercise = $em->getRepository(Exercise::class)->findOneBy(['id' => $id]);

        if (!$exercise) {
            throw $this->createNotFoundException('Exercise not found');
        }

        return $this->render('exercise/show.html.twig', [
            'exercise' => $exercise,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/exercise/create', name: 'exercise_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $exercise = new Exercise();
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($exercise);
            $em->flush();

            return $this->redirectToRoute('exercise_list');
        }

        return $this->render('exercise/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/exercise/edit/{id}', name: 'exercise_edit')]
    public function edit(Exercise $exercise, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('exercise_list');
        }

        return $this->render('exercise/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/exercise/delete/{id}', name: 'exercise_delete')]
    public function delete(Exercise $exercise, EntityManagerInterface $em): Response
    {
        $em->remove($exercise);
        $em->flush();
        return $this->redirectToRoute('exercise_list');
    }
}
