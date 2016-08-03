<?php
namespace AppBundle\DataFixtures\ORM;

use ApiBundle\Entity\Post;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class LoadPosts implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->setTitle('Test title');
            $post->setDescription('Test Description Test Description');
            $post->setBody('Test body Test body Test body Test body Test body Test body Test body Test body Test body Test body Test body Test body Test body Test body Test body Test body');
            $manager->persist($post);
        }

        $manager->flush();
    }


    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
        $this->container = $container;
    }

    public function getOrder()
    {
        return 10;
    }

}