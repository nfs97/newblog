<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 7/7/16
 * Time: 3:28 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use ApiBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\Post;


class IndexController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT a FROM ApiBundle:Post a ORDER BY a.id";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),/*page number*/
            5/*limit per page*/
        );


        return $this->render('AppBundle:Index:index.html.twig', [
            'pagination' => $pagination,
        ]);
    }


    /**
     * Finds and displays a Post entity.
     *
     * @Route("post/show/{id}", name="post_show")
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
        $views = $post->getViews();
        $post->setViews($views + 1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->render('AppBundle:Index:show.html.twig', [
            'post' => $post,
        ]);
    }

}