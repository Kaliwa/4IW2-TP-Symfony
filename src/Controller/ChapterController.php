<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Form\ChapterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChapterController extends AbstractController
{
    #[Route('/chapter', name: 'chapter_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $chapters = $em->getRepository(Chapter::class)->findAll();
        return $this->render('chapter/list.html.twig', [
            'chapters' => $chapters,
        ]);
    }

    #[Route('/chapter/{id}', name: 'chapter_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $chapter = $em->getRepository(Chapter::class)->findOneBy(['id' => $id]);

        if (!$chapter) {
            throw $this->createNotFoundException('Chapter not found');
        }

        return $this->render('chapter/show.html.twig', [
            'chapter' => $chapter,
        ]);
    }

    #[Route('/chapter/create', name: 'chapter_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $chapter = new Chapter();
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($chapter);
            $em->flush();

            return $this->redirectToRoute('chapter_list');
        }

        return $this->render('chapter/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/chapter/edit/{id}', name: 'chapter_edit')]
    public function edit(Chapter $chapter, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('chapter_list');
        }

        return $this->render('chapter/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/chapter/delete/{id}', name: 'chapter_delete')]
    public function delete(Chapter $chapter, EntityManagerInterface $em): Response
    {
        $em->remove($chapter);
        $em->flush();
        return $this->redirectToRoute('chapter_list');
    }
}
