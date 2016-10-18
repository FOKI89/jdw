<?php

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $testUser = new User();
        $testUser->setUsername('test');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($testUser, 'test');
        $testUser->setPassword($password);
        $testUser->setEmail('test@test.com');
        $testUser->setUsername('test');
        $testUser->setEnabled(true);

        $manager->persist($testUser);
        $manager->flush();
        echo "User test/test created\n";
    }

    /**
     * Sets the container.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}