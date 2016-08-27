<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 7/7/16
 * Time: 3:28 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;


/**
 * @Security("has_role('ROLE_USER')")
 */
class AdminController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/admin", name="admin_post_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('ApiBundle:Post')->findAll();
        $dql = "SELECT a FROM ApiBundle:Post a";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),/*page number*/
            10/*limit per page*/
        );


        return $this->render('AppBundle:Admin:index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("admin/post/new", name="admin_post_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        //$this->enforceUserSecurity();

        $post = new Post();
        $form = $this->createForm('ApiBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('admin_post_show', ['id' => $post->getId()]);
        }

        return $this->render('AppBundle:Admin:new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("admin/post/show/{id}", name="admin_post_show")
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
        return $this->render('AppBundle:Admin:show.html.twig', [
            'post' => $post,
            'delete_form' => $this->createDeleteForm($post)->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("admin/post/edit/{id}", name="admin_post_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post)
    {

        //$this->enforceUserSecurity();

        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('ApiBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('admin_post_edit', ['id' => $post->getId()]);
        }

        return $this->render('AppBundle:Admin:edit.html.twig', [
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("admin/post/delete/{id}", name="admin_post_delete")
     */
    public function deleteAction(Request $request, Post $post)
    {
        //$this->enforceUserSecurity();

        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('admin_post_index');
    }


    /**
     * Creates a form to delete a Post entity.
     *
     * @param Post $post The Post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_post_delete', ['id' => $post->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    private function enforceUserSecurity()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
    }

}