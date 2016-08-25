<?php

namespace ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Doctrine\ORM\EntityManager;
use ApiBundle\Entity\Media;

class UploadListener
{
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $file = $event->getFile();

        $object = new Media();
        $object->setImageName($file->getFilename());
        $object->setPath($file->getPathName());


        $this->manager->persist($object);
        $this->manager->flush();
    }
}