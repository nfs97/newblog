<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 7/7/16
 * Time: 3:28 PM
 */

namespace AppBundle\Controller;

use ApiBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


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

        $mostPopularPosts = $this->mostPopularPosts();

        return $this->render('AppBundle:Index:index.html.twig', [
            'pagination' => $pagination,
            'mostPopularPosts' => $mostPopularPosts,
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
        $em = $this->getDoctrine()->getManager();


        $views = $post->getViews();
        $post->setViews($views + 1);

        $em->persist($post);
        $em->flush();

        $mostPopularPosts = $this->mostPopularPosts();

        return $this->render('AppBundle:Index:show.html.twig', [
            'post' => $post,
            'mostPopularPosts' => $mostPopularPosts,
        ]);
    }

    private function mostPopularPosts()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('ApiBundle:Post')->findBy([], ['views' => 'DESC'], 5);
    }

}