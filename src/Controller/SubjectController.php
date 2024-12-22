<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubjectController extends AbstractController
{
    #[Route('/subject', name: 'subject_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $subjects = $em->getRepository(Subject::class)->findAll();
        return $this->render('subject/list.html.twig', [
            'subjects' => $subjects,
        ]);
    }

    #[Route('/subject/{id}', name: 'subject_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $subject = $em->getRepository(Subject::class)->findOneBy(['id' => $id]);
    
        if (!$subject) {
            throw $this->createNotFoundException('Subject not found');
        }
    
        return $this->render('subject/show.html.twig', [
            'subject' => $subject,
        ]);
    }
        

    #[Route('/subject/create', name: 'subject_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('subject_list');
        }

        return $this->render('subject/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/subject/edit/{id}', name: 'subject_edit')]
    public function edit(Subject $subject, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('subject_list');
        }

        return $this->render('subject/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/subject/delete/{id}', name: 'subject_delete')]
    public function delete(Subject $subject, EntityManagerInterface $em): Response
    {
        $em->remove($subject);
        $em->flush();
        return $this->redirectToRoute('subject_list');
    }
}
