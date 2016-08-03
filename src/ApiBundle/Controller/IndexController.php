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
            $response->setData($post);
            $response->setStatusCode(201);
        } else {
            $response->setStatusCode(400);
        }
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/posts")
     * @Route("/api/posts/{id}", name="post_read")
     * @Method({"GET"})
     */
    public function getAction($id = null)
    {
        $response = new JsonResponse();
        if (null === $id) {
            //TODO: pagination
            $posts = $this->getDoctrine()->getRepository('ApiBundle:Post')->findAll();
            $response->setStatusCode(200);
            foreach ($posts as $post => $index) {
                $posts[$index] = json_encode($post);
            }
        } else {
            if($posts = $this->getDoctrine()->getRepository('ApiBundle:Post')->find($id)){
                $response->setStatusCode(200);
            } else {
                $response->setStatusCode(404);
            }
        }
        $response->setData(json_encode(["posts" => $posts]));
        return $response;
    }

    /**
     * @Route("/api/posts")
     * @Route("/api/posts/{id}", name="post_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction($id = null)
    {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        if($post = $em->getRepository('ApiBundle:Post')->find($id)){
            $em->remove($post); //delete only one
            $em->flush();
            $response->setStatusCode(204);
        } else {
            $response->setStatusCode(404);
        }
        return $response;
    }

    /**
     * @Route("/api/posts/{id}", name="post_update")
     * @Method({"PUT"})
     */
    public function putAction(Request $request, $id = null)
    {
        $response = new JsonResponse();

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('ApiBundle:Post')->find($id);
        if ($post){
            $form = $this->createForm(PostType::class, $post);


            $form->submit([
                'title' => $request->request->get('title'),
                'description' => $request->request->get('description'),
                'body' => $request->request->get('body')
            ]);

            if ($form->isValid()) {

                $em->persist($post);
                $em->flush();
                $response->setData($post);
                $response->setStatusCode(204);
            } else {
                $response->setStatusCode(400);
            }

        } else {
            $response->setStatusCode(404);
        }


        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}