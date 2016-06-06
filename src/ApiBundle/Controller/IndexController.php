<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 4/28/16
 * Time: 1:29 PM
 */

namespace ApiBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ApiBundle\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use ApiBundle\Form\PostType;

class IndexController extends Controller
{
    /**
     * @Route("/api/posts", name="post_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $response = new JsonResponse();

        $form->submit([
            'title' => $request->request->get('title'),
            'description' => $request->request->get('description')
        ]);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $response->setStatusCode(201);
        } else {
            $response->setStatusCode(400);
        }
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}