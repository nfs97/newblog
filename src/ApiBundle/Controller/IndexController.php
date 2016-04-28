<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 4/28/16
 * Time: 1:29 PM
 */

namespace ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ApiBundle\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route("/api/posts", name="post_new")
     */
    public function newAction(Request $request)
    {
        $post = new Post();

        $response = new JsonResponse();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $response->setStatusCode(201);
        } else {
            $response->setStatusCode(400);
        }

        return $response;
    }

}