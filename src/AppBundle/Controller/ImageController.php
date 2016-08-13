<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 7/7/16
 * Time: 3:28 PM
 */

namespace AppBundle\Controller;

use ApiBundle\Entity\Media;
use ApiBundle\Form\MediaType;
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



class ImageController extends Controller
{

    /**
     * @Route("admin/media", name="upload_media")
     * @Method({"GET", "POST"})
     */
    public function mediaAction (Request $request)
    {
        $image = new Media();
        $form = $this->createForm(MediaType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded image file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $image->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where images are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // Update the 'image' property to store the PDF file name
            // instead of its contents
            $image->setImage($fileName);

            // ... persist the $product variable or any other work

            return $this->redirect($this->generateUrl('admin_post_index'));
        }

        return $this->render('AppBundle:Image:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}