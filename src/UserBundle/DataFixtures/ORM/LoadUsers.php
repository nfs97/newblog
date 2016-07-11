<?php
namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;



class LoadUsers implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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


        $user = new User();
        $user->setUsername('darth');
        $user->setIsActive(true);
        $user->setPassword($this->encodePassword($user,'darthpass'));
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('wayne');
        $admin->setIsActive(true);
        $admin->setPassword($this->encodePassword($admin,'waynepass'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

        $manager->flush();
    }

    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);

        return $encoded;

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