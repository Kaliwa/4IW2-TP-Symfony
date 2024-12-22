<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'classroom_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $classrooms = $em->getRepository(Classroom::class)->findAll();
        return $this->render('classroom/list.html.twig', [
            'classrooms' => $classrooms,
        ]);
    }

    #[Route('/classroom/create', name: 'classroom_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($classroom);
            $em->flush();

            return $this->redirectToRoute('classroom_list');
        }

        return $this->render('classroom/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/classroom/edit/{id}', name: 'classroom_edit')]
    public function edit(Classroom $classroom, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('classroom_list');
        }

        return $this->render('classroom/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/classroom/delete/{id}', name: 'classroom_delete')]
    public function delete(Classroom $classroom, EntityManagerInterface $em): Response
    {
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute('classroom_list');
    }
}
