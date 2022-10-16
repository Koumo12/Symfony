<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        
        $repository = $doctrine->getRepository(Post::class);
        $posts = $repository->findAll(); // SELECT * FROM
        dump($posts);
        return $this->render('post/demo.html.twig', [
            'posts' => $posts
        ]);
        
    }

    /**
     * @Route("/post/new")
     */
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
    
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $post->setUser($this->getUser()); // permet de récupérer l´utilisateur connecter
            $post->setPublishedAt(new \DateTime()); // permet d´enregister la date de creation du post
            $em = $doctrine->getManager();
            $em->persist($post);
            $em->flush();
        }

        return $this->render('post/form.html.twig', [
            'post_form' => $form->createView()
        ]);
        
    }

      /**
     * @Route("/post/edit/{id<\d+>}", name="edit-post")
     */
    public function update(Request $request, Post $post, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); // seul le user peut faire une publication
        
        if ($this->getUser() !== $post->getUser())
        {
             // eviter de modifier les publications d´une autres personnes 
             $this->addFlash("error", "Vous ne pouvez pas dupliquer une publication qui ne vous appartient pas");

            return $this->redirectToRoute("home");
        }
        $form = $this->createForm(PostType::class, $post);       
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render('post/form.html.twig', [
            'post_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/post/delete/{id<\d+>}", name="delete-post")
     */
    public function delete(Post $post, ManagerRegistry $doctrine): Response
    {   if ($this->getUser() !== $post->getUser())
        {
            return $this->redirectToRoute("home");
        }
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $doctrine->getManager();
        $em->remove($post);
        $em->flush();    
        
        return $this->redirectToRoute("home");
    }

   /**
     * @Route("/post/copy/{id<\d+>}", name="copy-post")
     */
    public function duplicate(Post $post, ManagerRegistry $doctrine): Response
    {
        if ($this->getUser() !== $post->getUser())
        {   
            return $this->redirectToRoute("home");
        }

        $copyPost = clone $post;       
        
        $em = $doctrine->getManager();
        $em->persist($copyPost);
        $em->flush();
        return $this->redirectToRoute("home");
    }

}
