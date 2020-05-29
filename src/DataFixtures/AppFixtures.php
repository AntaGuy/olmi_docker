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
        $user->setLastName('ANTADIS');
        $user->setFirstName('Hebergement');
        $user->setEmail('hebergement@antadis.com');
        $user->setUsername('antadis');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'antadis78'));
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $manager->persist($user);
        $manager->flush();
    }
}
