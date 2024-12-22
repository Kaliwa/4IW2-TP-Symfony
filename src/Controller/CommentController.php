<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'comment_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $comments = $em->getRepository(Comment::class)->findAll();
        return $this->render('comment/list.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/comment/create', name: 'comment_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_list');
        }

        return $this->render('comment/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/comment/edit/{id}', name: 'comment_edit')]
    public function edit(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('comment_list');
        }

        return $this->render('comment/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/comment/delete/{id}', name: 'comment_delete')]
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute('comment_list');
    }
}
