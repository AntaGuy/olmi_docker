<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setLastName('OLMI');
        $user->setFirstName('Admin');
        $user->setEmail('admin@olmi.com');
        $user->setUsername('olmi');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'olmi'));
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $manager->persist($user);
        $manager->flush();
    }
}
